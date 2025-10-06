@extends('layouts.app')

@section('title', 'PPC - MWS Control Center | PT Dirgantara Indonesia')

@section('content')
<nav x-data="{ isOpen: false }" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 backdrop-blur-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
      <div class="flex items-center space-x-3">
        <div class="w-8 h-8 flex items-center justify-center">
          <img src="{{ asset('img/PTDI.png') }}" alt="Logo PT DI" class="h-full w-full object-contain" />
        </div>
        <div class="flex flex-col">
          <span class="text-xl font-semibold text-white">PPC - MWS</span>
          <span class="text-sm text-blue-200 hidden sm:block">Maintenance Work Sheet</span>
        </div>
      </div>

      <div class="hidden md:flex items-center space-x-8">
        <a href="#home" class="text-white hover:text-blue-300 px-3 py-2 text-sm font-medium transition-colors duration-200">Home</a>
        <a href="#dashboard-preview" class="text-white hover:text-blue-300 px-3 py-2 text-sm font-medium transition-colors duration-200">Dashboard</a>
        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">Login</a>
      </div>

      <div class="md:hidden">
        <button @click="isOpen = !isOpen" class="p-2 rounded-xl text-white hover:text-blue-300 hover:bg-white/10">
          <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
          </svg>
          <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" style="display:none">
            <line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/>
          </svg>
        </button>
      </div>
    </div>

    <div x-show="isOpen" class="md:hidden bg-black/60 backdrop-blur-md border-t border-white/20 mt-2" style="display:none">
      <a href="#home" class="block px-3 py-2 text-white hover:text-blue-300">Home</a>
      <a href="#dashboard-preview" class="block px-3 py-2 text-white hover:text-blue-300">Dashboard</a>
      <a href="#" class="block mt-3 px-3 py-2 bg-blue-600 text-center rounded-lg hover:bg-blue-700">Login</a>
    </div>
  </div>
</nav>

<section id="home" 
  class="relative min-h-screen flex items-center justify-center pt-16 overflow-hidden perspective-[1000px]"
  x-data 
  x-init="
    const bg = $el.querySelector('.bg-hero');
    let mouseX = 0, mouseY = 0, targetX = 0, targetY = 0;

    const update = () => {
      targetX += (mouseX - targetX) * 0.05;
      targetY += (mouseY - targetY) * 0.05;
      bg.style.transform = `
        rotateY(${targetX * 0.1}deg)
        rotateX(${-targetY * 0.1}deg)
        translateZ(40px)
        scale(1.08)
      `;
      requestAnimationFrame(update);
    };
    update();

    $el.addEventListener('mousemove', e => {
      mouseX = (e.clientX / window.innerWidth - 0.5) * 100;
      mouseY = (e.clientY / window.innerHeight - 0.5) * 100;
    });

    $el.addEventListener('mouseleave', () => {
      mouseX = 0; mouseY = 0;
    });
  "
  style="
    background: linear-gradient(180deg, #d6d8dc 0%, #cfd1d5 50%, #bfc2c6 100%);
    transform-style: preserve-3d;
  "
>
  <div 
    class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-hero transition-transform duration-300 ease-out"
    style="background-image: url('{{ asset('img/plane.jpeg') }}');
           background-size: cover;
           background-position: center;
           transform-origin: center;">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60"></div>
  </div>
  <div class="absolute inset-0 pointer-events-none">
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-radial from-white/5 via-transparent to-transparent opacity-50"></div>
  </div>
  <div class="relative z-10 text-center px-4" style="transform: translateZ(80px);">
    <h1 class="text-4xl md:text-5xl font-semibold mb-4 text-white drop-shadow-lg">
      Welcome to PPC – MWS
      <span class="block text-blue-300">Control Center</span>
    </h1>
    <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-2xl mx-auto drop-shadow">
      Pantau, rencanakan, dan kendalikan perawatan pesawat secara real-time untuk operasi yang andal dan tepat waktu
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="#" class="inline-flex items-center px-8 py-4 bg-blue-600 text-white text-lg font-semibold rounded-xl hover:bg-blue-700 transition">Login →</a>
      <a href="#dashboard-preview" class="inline-flex items-center px-8 py-4 bg-white/90 text-slate-800 text-lg font-semibold rounded-xl hover:bg-white">View Dashboard</a>
    </div>
  </div>
</section>

<section id="dashboard-preview" class="py-24 bg-slate-50 text-slate-800">
  <div class="text-center">
    <h2 class="text-3xl font-semibold mb-4">Dashboard Preview</h2>
    <p class="text-lg text-slate-600">Belom Buatt </p>
  </div>
</section>

<footer class="bg-slate-900 text-center text-slate-400 py-4">
  <p>© {{ date('Y') }} PT Dirgantara Indonesia</p>
</footer>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
