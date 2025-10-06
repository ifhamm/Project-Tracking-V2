@extends('layouts.app')

@section('title', 'Buat MWS Baru - Sistem Aircraft Maintenance')

@section('content')
    <div class="flex h-screen bg-gray-50 font-sans">
        @includeIf('components.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                    <button id="sidebar-toggle-button" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>

                    <div class="flex-1 flex justify-center md:justify-start items-center space-x-4">
                        <a href="{{ url('/') }}"
                            class="px-6 py-3 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors duration-200">
                            Batal
                        </a>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center">
                                <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
                                Informasi Detail
                            </h1>
                            <p class="hidden sm:block text-sm text-gray-500 ml-9">Isi semua detail yang diperlukan di bawah
                                ini.</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                        <form id="createMwsForm" action="{{ route('mws.store') }}" method="POST"
                            class="space-y-10 p-6 sm:p-8">
                            @csrf

                            {{-- Detail Pekerjaan & Komponen --}}
                            <fieldset class="space-y-6">
                                <legend class="text-lg font-bold text-gray-800 border-l-4 border-blue-500 pl-3">Detail
                                    Pekerjaan & Komponen</legend>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ref Logistic /
                                            PPC</label>
                                        <input type="text" name="ref_logistic_ppc" class="form-input w-full"
                                            placeholder="Boleh dikosongkan">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer *</label>
                                        <input type="text" name="customer" class="form-input w-full" required
                                            placeholder="Contoh: Garuda Indonesia">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">WBS No. *</label>
                                        <input type="text" name="wbs_no" class="form-input w-full" required
                                            placeholder="Contoh: A/S90-025CN235-90-99-99">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Part Name / Title
                                            *</label>
                                        <input type="text" name="title_name" class="form-input w-full" required
                                            placeholder="Contoh: Angle of Attack Indicator">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Part Number *</label>
                                        <input type="text" name="part_number" class="form-input w-full" required
                                            placeholder="Contoh: AOA-001">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Serial Number *</label>
                                        <input type="text" name="serial_number" class="form-input w-full" required
                                            placeholder="Contoh: SN123456">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">MDR Doc Defect</label>
                                        <input type="text" name="mdr_doc_defect" class="form-input w-full"
                                            placeholder="Boleh dikosongkan">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Capability</label>
                                        <input type="text" name="capability" class="form-input w-full"
                                            placeholder="Boleh dikosongkan">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Shop Area *</label>
                                        <input type="text" name="shop_area" class="form-input w-full" required
                                            placeholder="Contoh: IN">
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Remark MWS</label>
                                        <textarea name="remark_mws" rows="3" class="form-input w-full"
                                            placeholder="Catatan atau remark tambahan... (Boleh kosong)"></textarea>
                                    </div>

                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Test Result</label>
                                        <input type="text" name="test_result" class="form-input w-full"
                                            placeholder="Hasil pengetesan... (Boleh kosong)">
                                    </div>
                                </div>
                            </fieldset>

                            {{-- Informasi Tambahan --}}
                            <fieldset class="space-y-6">
                                <legend class="text-lg font-bold text-gray-800 border-l-4 border-green-500 pl-3">Informasi
                                    Tambahan</legend>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">

                                    <div id="jobTypeContainer" class="relative">
                                        <label for="jobTypeSearch"
                                            class="block text-sm font-medium text-gray-700 mb-2">Jenis Pekerjaan *</label>
                                        <div class="relative flex items-center">
                                            <input type="text" id="jobTypeSearch" class="form-input w-full"
                                                placeholder="Memuat jenis pekerjaan..." autocomplete="off" disabled>
                                            <button type="button" id="addJobTypeBtn" title="Tambah baru"
                                                class="absolute right-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md h-7 w-7 flex items-center justify-center transition-all duration-200 transform hover:scale-110">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        <input type="hidden" name="job_type" id="jobTypeInput" required>
                                        <div id="jobTypeDropdown"
                                            class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-w-sm">
                                            <ul id="jobTypeList" class="max-h-56 overflow-y-auto py-1"></ul>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ref (CMM, etc)
                                            *</label>
                                        <input type="text" name="ref" class="form-input w-full" required
                                            placeholder="Contoh: CMM 34-12-24">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">A/C Type</label>
                                        <input type="text" name="ac_type" class="form-input w-full"
                                            placeholder="Boleh dikosongkan">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Worksheet No. *</label>
                                        <input type="text" name="worksheet_no" class="form-input w-full" required
                                            placeholder="Contoh: IN-108">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Revision</label>
                                        <input type="text" name="revision" class="form-input w-full" value="1">
                                    </div>
                                </div>
                            </fieldset>

                            {{-- Tombol --}}
                            <div class="flex justify-end items-center space-x-4 pt-6 border-t border-gray-200 mt-6">
                                <a href="{{ url('/') }}"
                                    class="px-6 py-3 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 font-medium transition-colors duration-200">
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold shadow-md transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-save mr-2"></i> Buat MWS
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script src="{{ asset('js/create_mws.js') }}" defer></script>
@endsection
