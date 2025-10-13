@extends('layouts.app')

@section('title', 'Langkah MWS - ' . $mwsPart->title)

@section('content')
    <div class="flex h-screen bg-gray-50">
        @includeIf('components.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200 p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-800">
                    <i class="fas fa-tasks text-blue-500 mr-2"></i> Langkah Pekerjaan - {{ $mwsPart->title }}
                </h1>
                <a href="{{ route('mws.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition">Kembali ke Daftar
                    MWS</a>
            </header>

            <main class="p-6 space-y-8 overflow-y-auto">
                {{-- Form tambah step --}}
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">Tambah Langkah Baru</h2>
                    <form action="{{ route('mws.steps.store') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @csrf
                        <input type="hidden" name="id_mws_part" value="{{ $mwsPart->id_mws_part }}">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Step No</label>
                            <input type="number" name="step_no" class="form-input w-full" required min="1">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="text" name="description" class="form-input w-full" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Details</label>
                            <textarea name="details" class="form-input w-full" rows="3"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Planned Man</label>
                            <input type="number" name="plan_man" class="form-input w-full">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Planned Hours</label>
                            <input type="number" name="plan_hours" class="form-input w-full" step="0.1">
                        </div>

                        <div class="md:col-span-2 flex justify-end">
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                Tambah Langkah
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tabel daftar langkah --}}
                <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                    <h2 class="text-lg font-semibold mb-4">Daftar Langkah</h2>

                    <table class="min-w-full border-collapse border border-gray-200 text-sm">
                        <thead class="bg-gray-100 text-gray-700 font-semibold">
                            <tr>
                                <th class="border p-2">#</th>
                                <th class="border p-2 text-left">Description</th>
                                <th class="border p-2">Planned</th>
                                <th class="border p-2">Actual</th>
                                <th class="border p-2">Status</th>
                                <th class="border p-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($steps as $step)
                                <tr>
                                    <td class="border p-2 text-center">{{ $step->step_no }}</td>
                                    <td class="border p-2">{{ $step->description }}</td>
                                    <td class="border p-2 text-center">{{ $step->plan_man }} / {{ $step->plan_hours }} jam
                                    </td>
                                    <td class="border p-2 text-center">{{ $step->man ?? '-' }} / {{ $step->hours ?? '-' }}
                                    </td>
                                    <td class="border p-2 text-center">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full
                                    {{ $step->status == 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($step->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="border p-2 text-center flex justify-center space-x-2">
                                        @if ($step->status != 'completed')
                                            <form action="{{ route('mws.steps.update', $step->id_mws_step) }}"
                                                method="POST">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button class="text-green-600 hover:text-green-800" title="Tandai selesai">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('mws.steps.destroy', $step->id_mws_step) }}" method="POST"
                                            onsubmit="return confirm('Hapus langkah ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-gray-500 py-4">Belum ada langkah</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
@endsection
