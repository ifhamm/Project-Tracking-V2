<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mws_parts;

class MwsPartController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'part_id' => 'required|string',
            'id_customer' => 'nullable|integer',
            'title' => 'nullable|string',
            'part_number' => 'nullable|string',
            'serial_number' => 'nullable|string',
            'job_type' => 'nullable|string',
            'start_date' => 'nullable|date',
        ]);

        $mws = mws_parts::create($data);

        // saved event akan memicu recalculate otomatis
        return response()->json(['success' => true, 'id' => $mws->id_mws_part]);
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

}