@extends('layouts.app')

@section('title', 'Login - Maintenance Work Sheet')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-200 p-4">
    <div class="max-w-md w-full">
        {{-- Logo dan Judul --}}
        <div class="text-center mb-8">
            <img src="{{ asset('img/PTDI.png') }}" 
                 alt="Logo PT DI" 
                 class="w-24 h-24 mx-auto mb-4 object-contain rounded-full shadow-lg bg-white p-2" />
            <h1 class="text-2xl font-bold text-gray-800">MAINTENANCE WORK SHEET</h1>
            <p class="text-sm text-gray-600">PT DIRGANTARA INDONESIA</p>
        </div>
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden relative">
            <div class="p-6 sm:p-8">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Selamat Datang</h2>
                    <p class="text-gray-500 text-sm">Masuk dengan NIK dan password</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div class="space-y-2">
                        <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-sm"></i>
                            </div>
                            <input type="text" name="nik" id="nik" required maxlength="6" 
                                   placeholder="Contoh: 000001"
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400 text-sm"></i>
                            </div>
                            <input type="password" name="password" id="password" required 
                                   placeholder="Masukkan password"
                                   class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <button type="button" id="togglePassword" 
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-600">
                                <i class="fas fa-eye text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 
                                   text-white py-3 px-4 rounded-lg font-semibold focus:outline-none focus:ring-4 
                                   focus:ring-blue-300 shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                    </button>
                </form>
            </div>
        </div>

        {{-- Akun Demo --}}
        <div class="mt-6 p-4 bg-white rounded-xl border border-gray-200 shadow-lg">
            <h6 class="font-semibold text-gray-700 mb-3 text-center">
                <i class="fas fa-users mr-2 text-blue-600"></i> Gunakan Akun Demo (Klik untuk mengisi)
            </h6>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs sm:text-sm">
                <button type="button" class="demo-account-btn" data-nik="200156" data-password="200156">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        <div><div class="font-semibold text-gray-800">Admin</div><div class="text-gray-500">200156 / 200156</div></div>
                    </div>
                </button>
                <button type="button" class="demo-account-btn" data-nik="140305" data-password="140305">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <div><div class="font-semibold text-gray-800">Mechanic</div><div class="text-gray-500">140305 / 140305</div></div>
                    </div>
                </button>
                <button type="button" class="demo-account-btn" data-nik="160183" data-password="160183">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <div><div class="font-semibold text-gray-800">Quality Inspector</div><div class="text-gray-500">160183 / 160183</div></div>
                    </div>
                </button>
                <button type="button" class="demo-account-btn" data-nik="130130" data-password="130130">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                        <div><div class="font-semibold text-gray-800">Quality CVDR</div><div class="text-gray-500">130130 / 130130</div></div>
                    </div>
                </button>
                <button type="button" class="demo-account-btn col-span-1 sm:col-span-2" data-nik="000005" data-password="123">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                        <div><div class="font-semibold text-gray-800">Super Admin</div><div class="text-gray-500">000005 / 123</div></div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.demo-account-btn {
    padding: 12px 16px;
    border-radius: 8px;
    background-color: white;
    border: 1px solid #e5e7eb;
    text-align: left;
    cursor: pointer;
    transition: all 0.2s;
}
.demo-account-btn:hover {
    background-color: #f8fafc;
    border-color: #3b82f6;
}
</style>

<script>
document.querySelectorAll('.demo-account-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('nik').value = btn.dataset.nik;
        document.getElementById('password').value = btn.dataset.password;
    });
});
document.getElementById('togglePassword').addEventListener('click', () => {
    const input = document.getElementById('password');
    input.type = input.type === 'password' ? 'text' : 'password';
});
</script>
@endsection