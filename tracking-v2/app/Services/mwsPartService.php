<?php

namespace App\Services;

use App\Models\mws_parts;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class MwsPartService
{
    protected array $holidays;

    public function __construct()
    {
        // Ambil daftar hari libur dari config/holidays.php (optional)
        // Format: ['2025-01-01', '2025-02-18', ...]
        $this->holidays = config('holidays.dates', []);
    }

    protected function isHoliday(Carbon $date): bool
    {
        return in_array($date->format('Y-m-d'), $this->holidays, true);
    }

    protected function safeParseDate($value): ?Carbon
    {
        if (!$value) return null;
        if ($value instanceof Carbon) return $value;
        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function calculateWorkingDaysBetween($start, $end): int
    {
        $startDate = $this->safeParseDate($start);
        $endDate = $this->safeParseDate($end);

        if (!$startDate || !$endDate || $endDate->lte($startDate)) {
            return 0;
        }

        $days = 0;
        $cursor = $startDate->copy();
        while ($cursor->lt($endDate)) {
            $cursor->addDay();
            if ($cursor->isWeekday() && !$this->isHoliday($cursor)) {
                $days++;
            }
        }
        return $days;
    }

    public function calculateSignedWorkingDaysBetween($start, $end): int
    {
        $s = $this->safeParseDate($start);
        $e = $this->safeParseDate($end);
        if (!$s || !$e) return 0;
        if ($e->lt($s)) {
            // negatif
            return -$this->calculateWorkingDaysBetween($e, $s);
        }
        return $this->calculateWorkingDaysBetween($s, $e);
    }

    public function calculateStrippingDeadline($start, int $days = 20): ?Carbon
    {
        $startDate = $this->safeParseDate($start);
        if (!$startDate) return null;

        $deadline = $startDate->copy();
        $added = 0;
        while ($added < $days) {
            $deadline->addDay();
            if ($deadline->isWeekday() && !$this->isHoliday($deadline)) {
                $added++;
            }
        }
        return $deadline;
    }

    private function getJobTypeWorkdays(?string $jobType): ?int
    {
        $map = [
            'Repair' => 60,
            'IRAN' => 60,
            'F.Test' => 3,
            'Overhaul' => 80,
            'Recharging' => 3,
            'Cleaning' => 3,
            'Assembly' => 60,
            'Deep Cycle' => 16,
            'Check' => 3,
            'Warranty' => 60,
            'Calibration' => 3,
        ];
        return $map[$jobType] ?? null;
    }

    public function updateScheduleFields(mws_parts $mws): void
    {
        $workdays = $this->getJobTypeWorkdays($mws->job_type);
        $mws->ecd_finish_workdays = $workdays;

        $start = $this->safeParseDate($mws->start_date);
        if ($start && $workdays !== null) {
            $deadline = $this->calculateStrippingDeadline($start, $workdays);
            $mws->schedule_delivery_on_time = $deadline ? $deadline->toDateString() : null;
        } else {
            $mws->schedule_delivery_on_time = null;
        }

        $this->updateSchedulePerformance($mws);
    }

    public function updateTaseStrippingFromDeadline(mws_parts $mws): void
    {
        // Jika jobType Recharging atau F.Test -> tidak ada tase stripping
        if (in_array($mws->job_type, ['Recharging', 'F.Test'], true)) {
            $mws->tase_stripping = null;
            $mws->stripping_report_date = null;
            $mws->max_stripping_date = null;
            $mws->selisih_stripping = null;
            return;
        }

        $start = $this->safeParseDate($mws->start_date);
        $report = $this->safeParseDate($mws->stripping_report_date);

        if (!$start || !$report) {
            $mws->tase_stripping = null;
            return;
        }

        $targetDays = 20;
        $actualWorkDays = $this->calculateWorkingDaysBetween($start, $report);

        if ($actualWorkDays <= $targetDays) {
            $percentage = 100;
        } else {
            $denominator = floatval($actualWorkDays);
            if ($denominator == 0.0) {
                $percentage = 0;
            } else {
                $percentage = ($targetDays / $denominator) * 100.0;
            }
        }

        $mws->tase_stripping = round(max(0, $percentage)) . '%';
    }

    public function updateStrippingDeadline(mws_parts $mws): void
    {
        if ($mws->start_date) {
            $deadline = $this->calculateStrippingDeadline($mws->start_date, 20);
            $mws->max_stripping_date = $deadline ? $deadline->toDateString() : null;
        } else {
            $mws->max_stripping_date = null;
        }
        $this->updateTaseStrippingFromDeadline($mws);
    }

    public function updateSchedulePerformance(mws_parts $mws): void
    {
        $schedule = $this->safeParseDate($mws->schedule_delivery_on_time);
        $actualFinish = $this->safeParseDate($mws->finish_date);
        $ecd = $mws->ecd_finish_workdays;

        if (!$schedule || !$actualFinish || $ecd === null) {
            $mws->work_days_difference = null;
            $mws->precentage_schedule = null;
            return;
        }

        $selisih = $this->calculateSignedWorkingDaysBetween($schedule, $actualFinish);
        $mws->work_days_difference = $selisih;

        if ($selisih <= 0) {
            $mws->precentage_schedule = '100%';
        } else {
            $denominator = floatval($ecd + $selisih);
            if ($denominator == 0.0) {
                $percentage = 0;
            } else {
                $percentage = ($ecd / $denominator) * 100.0;
            }
            $mws->precentage_schedule = round(max(0, $percentage)) . '%';
        }
    }

    public function updateShippingPerformance(mws_parts $mws): void
    {
        $finish = $this->safeParseDate($mws->finish_date);
        $ship = $this->safeParseDate($mws->ship_transfer_tt_date);
        if (!$finish || !$ship) {
            $mws->shipping_work_days_difference = null;
            $mws->tase = null;
            return;
        }

        $diff = $this->calculateWorkingDaysBetween($finish, $ship);
        $mws->shipping_work_days_difference = $diff;

        $grace = 5;
        if ($diff <= $grace) {
            $tasePerc = 100;
        } else {
            $over = $diff - $grace;
            $penalty = $over * 3;
            $tasePerc = 100 - $penalty;
        }
        $mws->tase = max(0, $tasePerc) . '%';
    }

    public function updateTotalDuration(mws_parts $mws): void
    {
        // total dari mws_steps->hours (format HH:MM)
        $totalMinutes = 0;
        foreach ($mws->mws_steps as $step) {
            $hours = $step->hours ?? null;
            if ($hours && strpos($hours, ':') !== false) {
                [$h, $m] = explode(':', $hours) + [0,0];
                $h = intval($h); $m = intval($m);
                $totalMinutes += ($h * 60) + $m;
            }
        }
        $finalH = intdiv($totalMinutes, 60);
        $finalM = $totalMinutes % 60;
        $mws->men_hours = sprintf('%02d:%02d', $finalH, $finalM);
    }

    public function updateMenPowers(mws_parts $mws): void
    {
        $unique = [];
        foreach ($mws->mws_steps as $step) {
            if (method_exists($step, 'get_mechanics')) {
                $arr = $step->get_mechanics();
            } else {
                // asumsi kolom mechanics disimpan sebagai comma-separated
                $arr = isset($step->mechanics) && $step->mechanics ? explode(',', $step->mechanics) : [];
            }
            foreach ($arr as $nik) {
                $nik = trim($nik);
                if ($nik !== '') $unique[$nik] = true;
            }
        }
        $mws->men_powers = (string) count($unique);
    }

    public function updateBdpMetrics(mws_parts $mws): void
    {
        // Ambil stripping records (relasi)
        $records = $mws->strippings;
        $validOpDates = [];
        foreach ($records as $r) {
            if (!empty($r->op_date)) $validOpDates[] = $r->op_date;
        }
        if (!empty($validOpDates)) {
            // paling baru
            $mws->stripping_report_date = max($validOpDates);
        } else {
            $mws->stripping_report_date = null;
        }

        $recordsForCalc = array_filter($records->toArray(), function ($r) {
            return !empty($r['bdp_name']) && trim($r['bdp_name']) !== '';
        });

        $totalValid = count($recordsForCalc);
        $mws->qty_bdp = $totalValid;

        if ($totalValid === 0) {
            $mws->percentage_bdp = '0%';
        } else {
            $complete = 0;
            foreach ($recordsForCalc as $r) {
                if (!empty($r['defect']) && !empty($r['mt_number']) && isset($r['mt_qty']) && !empty($r['mt_date'])) {
                    $complete++;
                }
            }
            $percentage = ($complete / $totalValid) * 100.0;
            $mws->percentage_bdp = round($percentage) . '%';
        }

        // update selisih stripping
        $this->updateStrippingSelisih($mws);
    }

    public function updateStrippingSelisih(mws_parts $mws): void
    {
        $deadline = $this->safeParseDate($mws->max_stripping_date);
        $report = $this->safeParseDate($mws->stripping_report_date);
        if (!$deadline || !$report) {
            $mws->selisih_stripping = null;
            return;
        }
        $mws->selisih_stripping = $this->calculateSignedWorkingDaysBetween($deadline, $report);
    }

    public function getStrippingStatus(mws_parts $mws): array
    {
        if (in_array($mws->job_type, ['Recharging', 'F.Test'], true)) {
            return ['status' => 'no_start_date', 'days_remaining' => null, 'percentage' => 100];
        }
        $start = $this->safeParseDate($mws->start_date);
        $maxstr = $this->safeParseDate($mws->max_stripping_date);
        if (!$start || !$maxstr) {
            return ['status' => 'no_start_date', 'days_remaining' => null, 'percentage' => 100];
        }
        $today = Carbon::today();
        $daysRemaining = $maxstr->diffInDays($today, false);
        $workingPassed = $this->calculateWorkingDaysBetween($start, $today);
        $workingRemaining = 20 - $workingPassed;

        $status = $workingPassed < 20 ? 'warning' : 'critical';

        if ($workingPassed < 20) {
            $percentage = 100;
        } else {
            $overdue = $workingPassed - 20;
            $percentage = 100 - ($overdue * 10);
        }

        return [
            'status' => $status,
            'days_remaining' => $daysRemaining,
            'percentage' => round($percentage, 1),
            'deadline_date' => $maxstr->toDateString(),
            'working_days_passed' => $workingPassed,
            'working_days_remaining' => $workingRemaining
        ];
    }

    /**
     * Jalankan semua kalkulasi utama (dipanggil setelah create/update)
     */
    public function recalculate(mws_parts $mws): void
    {
        // NOTE: gunakan relasi yg sudah eager loaded bila memungkinkan
        $this->updateScheduleFields($mws);
        $this->updateStrippingDeadline($mws);
        // updateBdpMetrics meng-set stripping_report_date juga
        $this->updateBdpMetrics($mws);
        $this->updateTaseStrippingFromDeadline($mws);
        $this->updateSchedulePerformance($mws);
        $this->updateShippingPerformance($mws);
        $this->updateTotalDuration($mws);
        $this->updateMenPowers($mws);

        // Simpan perubahan tanpa memicu event model lagi
        $mws->saveQuietly();
    }
}