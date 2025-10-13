<?php

namespace App\Http\Controllers;

use App\Models\mws_parts;
use App\Models\mws_steps;
use Illuminate\Http\Request;

class MwsStepController extends Controller
{
    public function index($id_mws_part)
    {
        $mwsPart = mws_parts::with('mws_steps')->findOrFail($id_mws_part);
        $steps = $mwsPart->mws_steps()->orderBy('step_no')->get();

        return view('mwsStep.index', compact('mwsPart', 'steps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mws_part' => 'required|exists:mws_parts,id_mws_part',
            'step_no' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'details' => 'nullable|string',
            'plan_man' => 'nullable|integer',
            'plan_hours' => 'nullable|numeric',
        ]);

        mws_steps::create($validated);
        return back()->with('success', 'Langkah baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $step = mws_steps::findOrFail($id);
        $step->update([
            'status' => $request->status ?? $step->status,
            'completed_by' => auth()->user()->name ?? 'System',
            'completed_date' => now(),
        ]);

        return back()->with('success', 'Status langkah diperbarui.');
    }

    public function destroy($id)
    {
        $step = mws_steps::findOrFail($id);
        $step->delete();

        return back()->with('success', 'Langkah dihapus.');
    }
}