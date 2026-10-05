<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Inventaris Aset IT MITSERI</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Dark Mode Autofill Fix */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus {
            -webkit-text-fill-color: #f8fafc !important;
            -webkit-box-shadow: 0 0 0px 1000px #0f172a inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #020617;
        }
        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-950 text-slate-100 antialiased selection:bg-blue-600 selection:text-white flex flex-col lg:flex-row overflow-x-hidden">

    <!-- HERO SECTION (LEFT SIDE ON DESKTOP) -->
    <div class="relative w-full lg:w-[55%] xl:w-[60%] min-h-[250px] lg:min-h-screen flex flex-col justify-between p-6 sm:p-10 lg:p-12 shrink-0 bg-slate-900 overflow-hidden">
        
        <!-- Background Image with Gradient Overlay -->
        <div 
            class="absolute inset-0 bg-cover bg-center bg-no-repeat transition-transform duration-1000 scale-105"
            style="background-image: url('{{ asset('images/bg-login.png') }}');"
        ></div>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/75 to-slate-900/60 lg:bg-gradient-to-r lg:from-slate-950/40 lg:via-slate-950/80 lg:to-slate-950"></div>
        
        <!-- Ambient Glowing Orbs -->
        <div class="absolute top-1/4 -left-20 w-80 h-80 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Top Header Pill / Badge -->
        <div class="relative z-10 flex items-center justify-between">
            <div class="inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-slate-900/80 border border-slate-700/60 backdrop-blur-md shadow-lg">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span class="text-xs font-semibold tracking-wider text-slate-200 uppercase">MITSERI SYSTEM v2.0</span>
            </div>

            <!-- Mobile Only Brand Name -->
            <div class="lg:hidden text-right">
                <span class="text-xs font-bold text-blue-400 block">REGISTRASI AKUN</span>
            </div>
        </div>

        <!-- Middle Hero Branding -->
        <div class="relative z-10 my-auto py-8 hidden sm:block">
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold mb-4 backdrop-blur-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Pendaftaran Pengguna Baru
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-4">
                    Bergabung ke Portal <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-cyan-400">Inventaris Aset IT</span>
                </h1>
                
                <p class="text-sm sm:text-base text-slate-300 leading-relaxed mb-8 font-normal max-w-lg">
                    Daftarkan akun baru untuk mengelola inventarisasi perangkat, pencatatan maintenance, dan pelaporan aset secara terpusat.
                </p>

                <!-- Key Highlights List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-medium text-slate-200">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-md">
                        <div class="p-2 rounded-lg bg-blue-500/20 text-blue-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <span>Akses Berbasis Peran (Admin & Staff)</span>
                    </div>

                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-900/60 border border-slate-800/80 backdrop-blur-md">
                        <div class="p-2 rounded-lg bg-indigo-500/20 text-indigo-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span>Manajemen Cepat & Efisien</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Notice -->
        <div class="relative z-10 hidden lg:block pt-4 border-t border-slate-800/80">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} MITSERI System. Seluruh hak cipta dilindungi undang-undang.
            </p>
        </div>

    </div>


    <!-- FORM SECTION (RIGHT SIDE) -->
    <div class="w-full lg:w-[45%] xl:w-[40%] min-h-[calc(100vh-250px)] lg:min-h-screen flex items-center justify-center p-4 sm:p-8 lg:p-12 relative z-10 bg-slate-950 overflow-y-auto">
        
        <!-- Subtle Ambient Light behind Form -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="w-full max-w-md my-auto relative">
            
            <!-- MAIN CARD -->
            <div class="bg-slate-900/80 border border-slate-800 backdrop-blur-2xl rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/80">
                
                <!-- BRANDING & TITLE -->
                <div class="flex flex-col items-center mb-6 text-center">
                    
                    <div class="relative mb-3 group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl blur opacity-40 group-hover:opacity-75 transition duration-300"></div>
                        <div class="relative p-2.5 bg-slate-900 border border-slate-700/80 rounded-2xl flex items-center justify-center shadow-lg">
                            <img 
                                src="{{ asset('img/logo.png') }}" 
                                alt="Logo MITSERI" 
                                class="h-10 w-auto object-contain drop-shadow"
                            >
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-white tracking-tight">
                        Buat Akun Baru
                    </h2>

                    <p class="text-xs sm:text-sm text-slate-400 mt-1 font-normal">
                        Isi formulir di bawah untuk membuat akun baru
                    </p>
                </div>


                <!-- REGISTER FORM -->
                <form 
                    method="POST" 
                    action="{{ route('register') }}" 
                    x-data="{ showPassword: false, showConfirmPassword: false, submitting: false }"
                    @submit="submitting = true"
                    class="space-y-4"
                >
                    @csrf

                    <!-- NAMA LENGKAP INPUT -->
                    <div>
                        <label for="name" class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Nama Lengkap
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>

                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}" 
                                required 
                                autofocus 
                                autocomplete="name"
                                placeholder="Nama lengkap Anda"
                                class="w-full bg-slate-950/70 border @if($errors->has('name')) border-red-500/80 focus:border-red-500 focus:ring-red-500/20 @else border-slate-700/80 focus:border-blue-500 focus:ring-blue-500/20 @endif rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-4 transition-all duration-200"
                            >
                        </div>

                        @if ($errors->has('name'))
                            <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first('name') }}</span>
                            </p>
                        @endif
                    </div>


                    <!-- EMAIL INPUT -->
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Email Akun
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>

                            <input 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email') }}" 
                                required 
                                autocomplete="username"
                                placeholder="nama@mitseri.com"
                                class="w-full bg-slate-950/70 border @if($errors->has('email')) border-red-500/80 focus:border-red-500 focus:ring-red-500/20 @else border-slate-700/80 focus:border-blue-500 focus:ring-blue-500/20 @endif rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-4 transition-all duration-200"
                            >
                        </div>

                        @if ($errors->has('email'))
                            <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first('email') }}</span>
                            </p>
                        @endif
                    </div>


                    <!-- PASSWORD INPUT -->
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Password
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>

                            <input 
                                id="password" 
                                :type="showPassword ? 'text' : 'password'" 
                                name="password" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-slate-950/70 border @if($errors->has('password')) border-red-500/80 focus:border-red-500 focus:ring-red-500/20 @else border-slate-700/80 focus:border-blue-500 focus:ring-blue-500/20 @endif rounded-xl pl-10 pr-11 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-4 transition-all duration-200"
                            >

                            <!-- Eye Toggle Button -->
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                tabindex="-1"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 focus:outline-none transition-colors"
                            >
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.381c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>

                        @if ($errors->has('password'))
                            <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first('password') }}</span>
                            </p>
                        @endif
                    </div>


                    <!-- KONFIRMASI PASSWORD INPUT -->
                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold text-slate-300 mb-1.5">
                            Konfirmasi Password
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>

                            <input 
                                id="password_confirmation" 
                                :type="showConfirmPassword ? 'text' : 'password'" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password"
                                placeholder="••••••••"
                                class="w-full bg-slate-950/70 border @if($errors->has('password_confirmation')) border-red-500/80 focus:border-red-500 focus:ring-red-500/20 @else border-slate-700/80 focus:border-blue-500 focus:ring-blue-500/20 @endif rounded-xl pl-10 pr-11 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-4 transition-all duration-200"
                            >

                            <!-- Eye Toggle Button -->
                            <button 
                                type="button"
                                @click="showConfirmPassword = !showConfirmPassword"
                                tabindex="-1"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-200 focus:outline-none transition-colors"
                            >
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.381c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>

                        @if ($errors->has('password_confirmation'))
                            <p class="mt-1.5 text-xs text-red-400 font-medium flex items-center gap-1.5">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $errors->first('password_confirmation') }}</span>
                            </p>
                        @endif
                    </div>


                    <!-- SUBMIT BUTTON -->
                    <button 
                        type="submit"
                        :disabled="submitting"
                        class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-sm py-3 rounded-xl shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 group mt-2 disabled:opacity-70 disabled:cursor-not-allowed"
                    >
                        <template x-if="!submitting">
                            <span class="flex items-center gap-2">
                                <span>Daftar Akun Baru</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </span>
                        </template>

                        <template x-if="submitting">
                            <span class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Memproses...</span>
                            </span>
                        </template>
                    </button>
                </form>


                <!-- LOGIN LINK -->
                @if (Route::has('login'))
                    <div class="mt-6 pt-5 border-t border-slate-800/80 text-center">
                        <p class="text-xs text-slate-400">
                            Sudah punya akun?
                            <a 
                                href="{{ route('login') }}" 
                                class="text-blue-400 hover:text-blue-300 font-bold ml-1 transition-colors hover:underline inline-flex items-center gap-1"
                            >
                                <span>Masuk sekarang</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </p>
                    </div>
                @endif

            </div>

        </div>

    </div>

</body>
</html>
