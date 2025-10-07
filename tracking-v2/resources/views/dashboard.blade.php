@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 sm:p-6 lg:p-8">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header Selamat Datang --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            {{-- Blade directive @auth untuk memeriksa apakah user sudah login --}}
            @auth
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}!</h1>
            <p class="text-gray-600 mt-1">Anda login sebagai 
                {{-- Menampilkan role dengan huruf kapital di awal --}}
                <span class="font-semibold text-blue-600">{{ Str::title(Auth::user()->role) ?? 'Role Tidak Diketahui' }}</span>.
            </p>
            @endauth
        </div>

        {{-- Card Informasi Akun --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user-circle mr-3 text-2xl"></i>
                    Informasi Akun Anda
                </h2>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-id-card w-6 text-center text-gray-400 mr-4"></i>
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-barcode w-6 text-center text-gray-400 mr-4"></i>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->nik }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-briefcase w-6 text-center text-gray-400 mr-4"></i>
                        <div>
                            <p class="text-sm text-gray-500">Role / Jabatan</p>
                            <p class="font-semibold text-gray-800">{{ Str::title(Auth::user()->role) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope w-6 text-center text-gray-400 mr-4"></i>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Logout --}}
        <div class="mt-8 text-center">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>

    </div>
</div>
@endsection