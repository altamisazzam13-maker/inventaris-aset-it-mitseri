<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Inventaris Aset IT MITSERI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-gradient-to-br from-blue-100/70 via-emerald-100/60 to-amber-100/70 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- DEKORASI LINGKARAN GRADASI WARNA LOGO MITSERI CERAH -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-400/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-24 w-96 h-96 bg-emerald-400/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 left-1/3 w-96 h-96 bg-amber-400/30 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md bg-white/90 backdrop-blur-xl border border-white/60 rounded-3xl p-8 shadow-2xl shadow-slate-300/50 relative z-10">
        <!-- Logo Header -->
        <div class="flex flex-col items-center mb-8 text-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo MITSERI" class="h-16 w-auto object-contain mb-3 drop-shadow-sm">
            <h1 class="font-bold text-xl text-slate-900 tracking-tight">Inventaris Aset IT</h1>
            <p class="text-xs text-blue-600 font-bold tracking-wider uppercase mt-0.5">MITSERI SYSTEM</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-semibold text-slate-700 mb-1.5">Email Akun</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                       placeholder="nama@mitseri.com"
                       class="w-full bg-slate-50/90 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                @if ($errors->has('email'))
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                <input id="password" 
                       :type="showPassword ? 'text' : 'password'" 
                       name="password" required 
                       placeholder="••••••••"
                       class="w-full bg-slate-50/90 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                @if ($errors->has('password'))
                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <!-- Checkbox Tampilkan Password -->
            <div class="flex items-center justify-between">
                <label for="show_password" class="inline-flex items-center gap-2 cursor-pointer select-none">
                    <input id="show_password" 
                           type="checkbox" 
                           @click="showPassword = !showPassword"
                           class="w-4 h-4 rounded border-slate-300 bg-slate-50 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <span class="text-xs text-slate-600 hover:text-slate-800">Tampilkan Password</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:text-blue-800 font-semibold transition-colors">
                        Lupa password?
                    </a>
                @endif
            </div>

            <!-- Tombol Masuk -->
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm py-3 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-95">
                Masuk ke System
            </button>
        </form>

        <!-- Link ke Register -->
        @if (Route::has('register'))
            <p class="mt-8 text-center text-xs text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-bold transition-colors">Daftar sekarang</a>
            </p>
        @endif
    </div>

</body>
</html>