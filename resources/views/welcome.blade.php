<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Poliklinik </title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:300;400;500;600;700;800&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.24/dist/full.min.css" rel="stylesheet" />
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                            colors: {
                                brand: { 50:'#ecfeff', 100:'#cffafe', 200:'#a5f3fc', 300:'#67e8f9', 400:'#22d3ee', 500:'#06b6d4', 600:'#0891b2', 700:'#0e7490', 800:'#155e75', 900:'#164e63' },
                                mint:  { 50:'#ecfdf5', 100:'#d1fae5', 200:'#a7f3d0', 300:'#6ee7b7', 400:'#34d399', 500:'#10b981', 600:'#059669' },
                            },
                            animation: {
                                'float': 'float 6s ease-in-out infinite',
                                'fade-up': 'fadeUp 0.7s ease-out forwards',
                                'fade-up-d1': 'fadeUp 0.7s ease-out 0.1s forwards',
                                'fade-up-d2': 'fadeUp 0.7s ease-out 0.2s forwards',
                                'fade-up-d3': 'fadeUp 0.7s ease-out 0.3s forwards',
                                'fade-up-d4': 'fadeUp 0.7s ease-out 0.4s forwards',
                                'pulse-soft': 'pulseSoft 3s ease-in-out infinite',
                            },
                            keyframes: {
                                float: { '0%,100%': { transform:'translateY(0)' }, '50%': { transform:'translateY(-12px)' } },
                                fadeUp: { '0%': { opacity:'0', transform:'translateY(24px)' }, '100%': { opacity:'1', transform:'translateY(0)' } },
                                pulseSoft: { '0%,100%': { opacity:'0.5' }, '50%': { opacity:'1' } },
                            }
                        }
                    }
                }
            </script>
            <style>
                [data-theme="light"] { --p: 8 100% 40%; --pf: 8 100% 35%; --pc: 8 100% 15%; --sf: 168 70% 38%; --af: 168 70% 35%; --nf: 215 25% 15%; --b2: 98% 100%; --bc: 215 25% 88%; }
                .opacity-0-init { opacity: 0; }
            </style>
        @endif
    </head>

    <body class="font-sans bg-base-100 text-base-content">

        <!-- ==================== NAVBAR ==================== -->
        <div class="navbar fixed top-0 left-0 right-0 z-50 bg-base-100/80 backdrop-blur-xl border-b border-base-200/50 lg:px-8 px-4 transition-all duration-300" id="navbar">
            <div class="navbar-start">
                <a href="/" class="flex items-center gap-2.5">
                    <div>
                        <img src="{{ asset('Logo_Bengkod.jpg') }}" alt="Logo"
                        class="w-[40px] h-[40px] rounded-[16px] object-cover mx-auto mb-[1px] block">
                    </div>
                    <span class="text-lg font-bold text-neutral-900">Poliklinik<span class="text-brand-500"></span></span>
                </a>
            </div>

            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal gap-1 text-sm font-medium text-neutral-500">
                    <li><a href="#layanan" class="hover:text-brand-600 rounded-lg">Layanan</a></li>
                    <li><a href="#dokter" class="hover:text-brand-600 rounded-lg">Dokter</a></li>
                    <li><a href="#kontak" class="hover:text-brand-600 rounded-lg">Kontak</a></li>
                </ul>
            </div>

            <div class="navbar-end gap-2">
                @auth
                    @role('admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary rounded-xl shadow-md shadow-brand-500/20">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Admin
                        </a>
                    @endrole
                    @role('dokter')
                        <a href="{{ route('dokter.dashboard') }}" class="btn btn-sm btn-primary rounded-xl shadow-md shadow-brand-500/20">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Dashboard
                        </a>
                    @endrole
                    @role('pasien')
                        <a href="{{ route('pasien.dashboard') }}" class="btn btn-sm btn-primary rounded-xl shadow-md shadow-brand-500/20">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            Dashboard
                        </a>
                    @endrole
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-ghost rounded-xl text-brand-600 font-medium hidden sm:flex">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-sm bg-[#1e2d6b] text-white rounded-xl shadow-md shadow-brand-500/20 hidden sm:flex">Daftar</a>
                @endauth

                <div class="dropdown dropdown-end lg:hidden">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-square btn-sm">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="4" y1="6" x2="20" y2="6"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-2xl z-[1] w-56 p-3 shadow-xl border border-base-200 mt-2">
                        <li><a href="#layanan">Layanan</a></li>
                        <li><a href="#dokter">Dokter</a></li>
                        <li><a href="#kontak">Kontak</a></li>
                        <div class="divider my-1"></div>
                        @auth
                            <li><a href="{{ route('logout') }}" method="POST" class="btn btn-ghost btn-sm rounded-xl text-error">Keluar</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="btn btn-ghost btn-sm rounded-xl">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="btn bg-[#1e2d6b] text-white btn-sm rounded-xl">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>

        <!-- ==================== HERO ==================== -->
        <section class="min-h-screen relative overflow-hidden bg-gradient-to-br from-brand-50 via-base-100 to-mint-50">
            <div class="absolute top-[-200px] right-[-150px] w-[600px] h-[600px] rounded-full bg-brand-200/30 blur-3xl"></div>
            <div class="absolute bottom-[-100px] left-[-100px] w-[400px] h-[400px] rounded-full bg-mint-200/30 blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-4 lg:px-8 pt-32 pb-20 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                    <!-- Kiri -->
                    <div>
                        <div class="animate-fade-up opacity-0-init inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-100/60 border border-brand-200/50 text-brand-700 text-sm font-medium">
                            <span class="w-2 h-2 rounded-full bg-mint-500 animate-pulse-soft"></span>
                            Melayani dengan Sepenuh Hati
                        </div>

                        <h1 class="animate-fade-up-d1 opacity-0-init text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold leading-[1.1] tracking-tight text-neutral-900 mt-6">
                            Perawatan
                            <span class="bg-gradient-to-r from-brand-500 to-mint-500 bg-clip-text text-transparent">Terbaik</span>
                            untuk Kesehatan Anda
                        </h1>

                        <p class="animate-fade-up-d2 opacity-0-init text-neutral-500 text-lg leading-relaxed mt-6 max-w-lg">
                            Poliklinik menyediakan layanan kesehatan komprehensif dengan dokter berpengalaman dan fasilitas modern.
                        </p>

                        <div class="animate-fade-up-d3 opacity-0-init flex flex-wrap gap-3 mt-8">
                            @auth
                                <a href="{{ route('pasien.dashboard') }}" class="btn btn-primary rounded-2xl px-8 shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5 transition-all duration-300">
                                    Ke Dashboard
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="btn bg-[#1e2d6b] text-white rounded-2xl px-8 shadow-lg shadow-brand-500/25 hover:shadow-xl hover:shadow-brand-500/30 hover:-translate-y-0.5 transition-all duration-300">
                                    Daftar Sekarang
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline rounded-2xl px-8 border-neutral-200 text-neutral-600 hover:border-brand-500 hover:text-brand-600 hover:-translate-y-0.5 transition-all duration-300">
                                    Sudah Punya Akun
                                </a>
                            @endauth
                        </div>

                        <!-- Stats -->
                        <div class="animate-fade-up-d4 opacity-0-init grid grid-cols-3 gap-4 mt-12 bg-base-100 rounded-2xl p-6 shadow-sm border border-base-200 max-w-md">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-neutral-900">{{ $totalDokter }}+</div>
                                <div class="text-xs text-neutral-400 mt-0.5">Dokter Ahli</div>
                            </div>
                            <div class="text-center border-x border-base-200">
                                <div class="text-2xl font-bold text-neutral-900">{{ $totalPoli }}</div>
                                <div class="text-xs text-neutral-400 mt-0.5">Poli Spesialis</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-neutral-900">{{ $totalPasien >= 1000 ? number_format($totalPasien / 1000) . 'K+' : $totalPasien }}</div>
                                <div class="text-xs text-neutral-400 mt-0.5">Pasien Terlayani</div>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan - Hero Card -->
                    <div class="flex justify-center lg:justify-end">
                        <div class="animate-float w-full max-w-sm">
                            <div class="bg-base-100 rounded-3xl p-7 shadow-2xl shadow-neutral-900/5 border border-base-200">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-100 to-mint-100 flex items-center justify-center text-2xl">🏥</div>
                                    <div>
                                        <div class="font-semibold text-neutral-900 text-sm">Pendaftaran Online</div>
                                        <div class="text-xs text-neutral-400">Tanpa antri, lebih praktis</div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    @forelse($jadwalTerdekat as $index => $jadwal)
                                        <div class="bg-base-200/50 rounded-2xl p-4">
                                            <div class="text-xs text-neutral-400 mb-1">
                                                {{ $jadwal->dokter->poli->nama_poli ?? 'Poli' }}
                                            </div>
                                            <div class="text-sm font-semibold text-neutral-900">
                                                {{ $jadwal->dokter->nama }}
                                            </div>
                                            <div class="text-xs {{ $index == 0 ? 'text-mint-600' : 'text-brand-600' }} mt-1.5 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                                                {{ $jadwal->hari }}, {{ substr($jadwal->jam_mulai, 0, 5) }} – {{ substr($jadwal->jam_selesai, 0, 5) }}
                                            </div>
                                        </div>
                                    @empty
                                        <div class="bg-base-200/50 rounded-2xl p-4 text-center text-neutral-400 text-sm">
                                            Belum ada jadwal tersedia
                                        </div>
                                    @endforelse
                                </div>

                                <div class="flex items-center justify-between pt-5 mt-5 border-t border-base-200">
                                    <span class="text-xs text-neutral-400">Jadwal {{ $hariIni ?? 'Hari Ini' }}</span>
                                    <span class="text-2xl font-bold text-neutral-900">{{ $jadwalTerdekat->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== LAYANAN ==================== -->
        <section class="py-24 bg-base-100" id="layanan">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="text-center max-w-2xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-100/60 text-brand-700 text-sm font-medium">
                        🏥 Layanan Kami
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 mt-4 tracking-tight">Layanan Kesehatan Lengkap</h2>
                    <p class="text-neutral-500 mt-3 leading-relaxed">Berbagai layanan kesehatan untuk memenuhi kebutuhan Anda dan keluarga.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mt-14">
                    <div class="card bg-base-100 border border-base-200 rounded-2xl hover:shadow-xl hover:shadow-brand-500/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="card-body p-7">
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">🩺</div>
                            <h3 class="card-title text-neutral-900 mt-4 text-lg">Poli Umum</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">Pemeriksaan kesehatan umum, konsultasi penyakit, dan tindakan medis dasar.</p>
                        </div>
                    </div>
                    <div class="card bg-base-100 border border-base-200 rounded-2xl hover:shadow-xl hover:shadow-brand-500/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="card-body p-7">
                            <div class="w-14 h-14 rounded-2xl bg-brand-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">🦷</div>
                            <h3 class="card-title text-neutral-900 mt-4 text-lg">Poli Gigi</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">Perawatan gigi dan mulut meliputi pembersihan, tambal, dan cabut gigi.</p>
                        </div>
                    </div>
                    <div class="card bg-base-100 border border-base-200 rounded-2xl hover:shadow-xl hover:shadow-brand-500/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="card-body p-7">
                            <div class="w-14 h-14 rounded-2xl bg-rose-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">❤️</div>
                            <h3 class="card-title text-neutral-900 mt-4 text-lg">Poli Jantung</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">Pemeriksaan jantung, EKG, echocardiography, dan konsultasi kardiovaskular.</p>
                        </div>
                    </div>
                    <div class="card bg-base-100 border border-base-200 rounded-2xl hover:shadow-xl hover:shadow-brand-500/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="card-body p-7">
                            <div class="w-14 h-14 rounded-2xl bg-mint-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">🧒</div>
                            <h3 class="card-title text-neutral-900 mt-4 text-lg">Poli Anak</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">Pemeriksaan tumbuh kembang, imunisasi, dan penanganan penyakit anak.</p>
                        </div>
                    </div>
                    <div class="card bg-base-100 border border-base-200 rounded-2xl hover:shadow-xl hover:shadow-brand-500/5 hover:-translate-y-1 transition-all duration-300 group">
                        <div class="card-body p-7">
                            <div class="w-14 h-14 rounded-2xl bg-violet-50 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">👁️</div>
                            <h3 class="card-title text-neutral-900 mt-4 text-lg">Poli Mata</h3>
                            <p class="text-neutral-500 text-sm leading-relaxed">Pemeriksaan penglihatan, pemeriksaan mata lengkap, dan gangguan penglihatan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==================== DOKTER (DINAMIS) ==================== -->
        <section class="py-24 bg-base-200/40" id="dokter">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="text-center max-w-2xl mx-auto">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-brand-100/60 text-brand-700 text-sm font-medium">
                        👨‍⚕️ Tim Medis
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-neutral-900 mt-4 tracking-tight">Dokter Terpercaya</h2>
                    <p class="text-neutral-500 mt-3 leading-relaxed">Dokter profesional yang siap memberikan pelayanan terbaik.</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-14">
                    @forelse($dokters as $dokter)
                        <div class="card bg-base-100 border border-base-200 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <figure class="h-44 bg-gradient-to-br from-brand-100/60 to-mint-100/60 flex items-center justify-center">
                                <span class="text-7xl">👨🏻‍⚕️</span>
                            </figure>
                            <div class="card-body p-5 pt-4">
                                <h3 class="font-semibold text-neutral-900">{{ $dokter->nama }}</h3>
                                <p class="text-brand-600 text-sm font-medium">{{ $dokter->poli->nama_poli ?? 'Belum ditugaskan' }}</p>

                                @if($dokter->jadwalPeriksa->count() > 0)
                                    @php
                                        $grouped = $dokter->jadwalPeriksa->groupBy('hari');
                                        $schedules = [];
                                        foreach($grouped as $hari => $items) {
                                            $jam = $items->map(fn($j) => substr($j->jam_mulai, 0, 5) . '–' . substr($j->jam_selesai, 0, 5))->join(', ');
                                            $schedules[] = "$hari, $jam";
                                        }
                                        $display = implode(' | ', array_slice($schedules, 0, 2));
                                        if(count($schedules) > 2) $display .= ' ...';
                                    @endphp
                                    <div class="flex items-start gap-1.5 text-neutral-400 text-xs mt-2">
                                        <svg class="w-3.5 h-3.5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                        <span>{{ $display }}</span>
                                    </div>
                                @else
                                    <div class="text-neutral-300 text-xs mt-2">Belum ada jadwal</div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="sm:col-span-2 lg:col-span-4 text-center py-16 text-neutral-400">
                            <div class="text-5xl mb-4">📋</div>
                            <p class="text-lg">Belum ada data dokter tersedia</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- ==================== CTA ==================== -->
        <section class="py-24 relative overflow-hidden" id="kontak">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-800 via-brand-700 to-mint-700"></div>
            <div class="absolute top-[-80px] right-[-80px] w-[350px] h-[350px] rounded-full bg-white/5"></div>
            <div class="absolute bottom-[-120px] left-[-80px] w-[450px] h-[450px] rounded-full bg-white/5"></div>

            <div class="max-w-2xl mx-auto px-4 text-center relative z-10">
                <h2 class="text-3xl sm:text-4xl font-bold text-black tracking-tight">Jaga Kesehatan Anda<br>Mulai dari Sekarang</h2>
                <p class="text-black/60 mt-4 leading-relaxed text-lg">Daftar sebagai pasien dan kelola jadwal pemeriksaan dengan mudah.</p>

                @auth
                    <a href="{{ route('pasien.dashboard') }}" class="btn btn-lg bg-white text-brand-800 hover:bg-white/90 border-none rounded-2xl mt-8 shadow-xl shadow-black/10 hover:-translate-y-0.5 transition-all duration-300">
                        Buka Dashboard
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-lg bg-white text-brand-800 hover:bg-white/90 border-none rounded-2xl mt-8 shadow-xl shadow-black/10 hover:-translate-y-0.5 transition-all duration-300">
                        Daftar Gratis
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>
        </section>

        <!-- ==================== FOOTER ==================== -->
        <footer class="bg-neutral-900 text-neutral-400 py-10">
            <div class="max-w-7xl mx-auto px-4 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="/" class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-500 to-mint-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-black" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>
                            </svg>
                        </div>
                        <span class="font-semibold text-neutral-200 text-sm">Poliklinik</span>
                    </a>
                    <div class="text-sm">&copy; 2025 Poliklinik. Hak cipta dilindungi.</div>
                </div>
            </div>
        </footer>

        <!-- ==================== SCRIPTS ==================== -->  
        <script>
            window.addEventListener('scroll', () => {
                const nav = document.getElementById('navbar');
                nav.classList.toggle('shadow-lg', window.scrollY > 20);
                nav.classList.toggle('shadow-neutral-900/5', window.scrollY > 20);
            });

            document.querySelectorAll('a[href^="#"]').forEach(a => {
                a.addEventListener('click', e => {
                    e.preventDefault();
                    const target = document.querySelector(a.getAttribute('href'));
                    if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                });
            });
        </script>
    </body>
</html>