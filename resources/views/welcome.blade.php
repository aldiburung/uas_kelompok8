<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Website KDKMP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-700 via-red-600 to-[#ff5454] text-white">
    <div class="min-h-screen px-4 py-8 sm:px-6 lg:px-12">
        <div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-[1.4fr_1fr] items-center">
            <div class="space-y-8 rounded-[40px] bg-white/10 p-8 ring-1 ring-white/10 shadow-2xl backdrop-blur-2xl sm:p-12">
                <div class="space-y-5">
                    <p class="text-sm uppercase tracking-[0.35em] text-red-100">Welcome to Website KDKMP</p>
                    <h1 class="text-4xl sm:text-5xl font-bold text-white">Sistem Barter dan Keuangan Desa yang Modern</h1>
                    <p class="max-w-2xl text-base text-red-100/90">Akses cepat untuk mengelola transaksi, komoditas barter, riwayat transaksi barter, dan termin secara mudah. Semua role akan menikmati tampilan yang konsisten dan profesional.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-3xl bg-white/10 p-6 border border-white/20">
                        <h2 class="text-lg font-semibold text-white">Login Cepat</h2>
                        <p class="mt-3 text-sm text-red-100/90">Masuk untuk melihat dashboard dan kelola sistem.</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-3xl bg-white px-6 py-3 text-sm font-semibold text-red-700 shadow-lg shadow-red-800/20 hover:bg-red-50">Masuk</a>
                </div>
            </div>

            <div class="rounded-[40px] bg-white/10 p-8 ring-1 ring-white/10 shadow-2xl backdrop-blur-2xl sm:p-10">
                <div class="mb-8 rounded-[32px] bg-white/10 p-6 border border-white/20">
                    <h2 class="text-xl font-semibold text-white">Tampilan konsisten untuk semua role</h2>
                    <p class="mt-3 text-sm text-red-100/90">Hanya ada dua role sekarang: keuangan dan barter. Keduanya mendapatkan UI yang terstruktur dan mudah dipakai.</p>
                </div>
                <div class="grid gap-4">
                    <div class="rounded-3xl bg-white/10 p-5 border border-white/10">
                        <p class="font-semibold text-white">Dashboard Ringkas</p>
                        <p class="mt-2 text-sm text-red-100/90">Ringkasan transaksi, komoditas, dan aktivitas terbaru di satu halaman.</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5 border border-white/10">
                        <p class="font-semibold text-white">Akses Barter</p>
                        <p class="mt-2 text-sm text-red-100/90">Kelola barter secara terpusat dan pantau setiap permintaan.</p>
                    </div>
                    <div class="rounded-3xl bg-white/10 p-5 border border-white/10">
                        <p class="font-semibold text-white">Keuangan Desa</p>
                        <p class="mt-2 text-sm text-red-100/90">Transaksi dicatat dengan jelas, sehingga bendahara dapat bekerja lebih cepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
