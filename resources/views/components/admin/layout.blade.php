<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin - Darul Fikri' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:z-50 focus:px-4 focus:py-2 focus:bg-primary-700 focus:text-white focus:rounded-lg">
        Lompat ke konten utama
    </a>

    <div class="flex min-h-screen">
        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/50 z-20 lg:hidden"></div>

        <!-- Sidebar -->
        <div class="w-64 shrink-0 bg-primary-950 flex flex-col fixed inset-y-0 left-0 z-30 transition-transform -translate-x-full lg:translate-x-0"
             :class="sidebarOpen && '!translate-x-0'">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-6 h-16 border-b border-white/10">
                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gold-500 text-primary-950 font-display font-bold text-sm shrink-0">DF</span>
                <span class="min-w-0">
                    <span class="block font-display font-bold text-white text-sm truncate">Darul Fikri</span>
                    <span class="block text-[11px] text-primary-300 truncate">Admin Panel</span>
                </span>
            </a>

            <nav aria-label="Navigasi admin" role="navigation" class="flex-1 p-3 space-y-0.5 overflow-y-auto">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'home', 'label' => 'Dashboard'],
                        ['route' => 'admin.education-levels.index', 'active' => 'admin.education-levels.*', 'icon' => 'academic-cap', 'label' => 'Jenjang Pendidikan'],
                        ['route' => 'admin.hero-slides.index', 'active' => 'admin.hero-slides.*', 'icon' => 'photo', 'label' => 'Carousel Beranda'],
                        ['route' => 'admin.academic-years.index', 'active' => 'admin.academic-years.*', 'icon' => 'calendar', 'label' => 'Tahun Ajaran'],
                    ];
                @endphp
                @foreach ($navItems as $item)
                    @php $isActive = request()->routeIs($item['active']); @endphp
                    <a href="{{ route($item['route']) }}"
                       @if($isActive) aria-current="page" @endif
                       class="relative flex items-center gap-3 pl-3.5 pr-3 py-2.5 rounded-lg text-sm font-medium transition
                              @if($isActive) bg-white/10 text-white @else text-primary-200 hover:bg-white/5 hover:text-white @endif">
                        @if ($isActive)
                            <span class="absolute left-0 top-1.5 bottom-1.5 w-1 rounded-full bg-gold-500"></span>
                        @endif
                        <x-admin.icon :name="$item['icon']" class="w-5 h-5 shrink-0" />
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="p-3 border-t border-white/10">
                <a href="{{ route('admin.account') }}"
                   @if(request()->routeIs('admin.account')) aria-current="page" @endif
                   class="flex items-center gap-2.5 px-2 py-2 mb-1 rounded-lg transition hover:bg-white/5">
                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-700 text-white text-xs font-semibold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-sm text-white truncate">{{ auth()->user()->name }}</span>
                        <span class="block text-xs text-primary-300 truncate">{{ auth()->user()->email }}</span>
                    </span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-3 pl-3.5 pr-3 py-2.5 rounded-lg text-sm font-medium text-primary-200 hover:bg-white/5 hover:text-white transition">
                        <x-admin.icon name="logout" class="w-5 h-5 shrink-0" />
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 lg:ml-64">
            <!-- Top Bar -->
            <div class="h-16 bg-white border-b border-slate-200 flex items-center gap-3 px-4 sm:px-6 sticky top-0 z-10">
                <button type="button" @click="sidebarOpen = !sidebarOpen"
                        aria-label="Buka menu navigasi" aria-expanded="false" :aria-expanded="sidebarOpen"
                        class="lg:hidden p-2 -ml-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <x-admin.icon name="menu" class="w-6 h-6" />
                </button>
                <h1 class="text-lg font-semibold text-slate-900 truncate flex-1">{{ $title ?? 'Dashboard' }}</h1>
                <livewire:admin.academic-year-switcher />
            </div>

            <!-- Content -->
            <div id="main-content" class="p-4 sm:p-6 min-w-0">
                {{ $slot }}
            </div>
        </div>
    </div>

    <x-admin.toast-stack />
    <x-admin.confirm-dialog />

    @if (session('success') || session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                @if (session('success'))
                    Alpine.store('toast').push('success', @js(session('success')));
                @endif
                @if (session('error'))
                    Alpine.store('toast').push('error', @js(session('error')));
                @endif
            });
        </script>
    @endif
</body>
</html>
