<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mws_parts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MwsPartController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $validated = Validator::make($data, [
            'ref_logistic_ppc' => 'nullable|string',
            'customer' => 'required|string',
            'wbs_no' => 'required|string',
            'title_name' => 'required|string',
            'part_number' => 'required|string',
            'serial_number' => 'required|string',
            'mdr_doc_defect' => 'nullable|string',
            'capability' => 'nullable|string',
            'shop_area' => 'required|string',
            'remark_mws' => 'nullable|string',
            'test_result' => 'nullable|string',
            'job_type' => 'required|string',
            'ref' => 'required|string',
            'ac_type' => 'nullable|string',
            'worksheet_no' => 'required|string',
            'revision' => 'nullable|string',
        ])->validate();

        // 🔒 Gunakan transaksi untuk mencegah race condition
        $mws = DB::transaction(function () use ($data) {

            // Kunci tabel mws_parts untuk mencegah duplikasi nomor
            $lastMws = DB::table('mws_parts')
                ->select('part_id')
                ->orderByDesc('id_mws_part')
                ->lockForUpdate()
                ->first();

            $nextNum = 1;

            if ($lastMws && preg_match('/MWS-(\d+)$/', $lastMws->part_id, $matches)) {
                $nextNum = intval($matches[1]) + 1;
            }

            $newPartId = sprintf("MWS-%03d", $nextNum);

            // Simpan data
            $mws = \App\Models\mws_parts::create([
                'part_id' => $newPartId,
                'ref_logistic_ppc' => $data['ref_logistic_ppc'] ?? null,
                'customer_name' => $data['customer'],
                'wbs_no' => $data['wbs_no'],
                'title' => $data['title_name'],
                'part_number' => $data['part_number'],
                'serial_number' => $data['serial_number'],
                'mdr_doc_defect' => $data['mdr_doc_defect'] ?? null,
                'capability' => $data['capability'] ?? null,
                'shop_area' => $data['shop_area'],
                'remark_wms' => $data['remark_mws'] ?? null,
                'test_result' => $data['test_result'] ?? null,
                'job_type' => $data['job_type'],
                'ref_no' => $data['ref'],
                'ac_type' => $data['ac_type'] ?? null,
                'worksheet_no' => $data['worksheet_no'],
                'revision' => $data['revision'] ?? 1,
                'start_date' => now(),
            ]);

            return $mws;
        });

        return response()->json([
            'success' => true,
            'id' => $mws->id_mws_part,
            'part_id' => $mws->part_id,
        ]);
    }



    public function update(Request $request, $id)
    {
        $mws = mws_parts::findOrFail($id);
        $mws->update($request->all());

        // saved event sudah memicu recalculate

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $mws = mws_parts::with(['mws_steps', 'strippings'])->findOrFail($id);
        return response()->json($mws);
    }

    public function getJobTypes()
    {
        return response()->json([
            'success' => true,
            'job_types' => ['Inspection', 'Repair', 'Testing', 'Overhaul', 'Calibration']
        ]);
    }

    public function index()
    {
        $mwsParts = \App\Models\mws_parts::orderByDesc('created_at')->get();
        return view('mws_part.index', compact('mwsParts'));
    }

}