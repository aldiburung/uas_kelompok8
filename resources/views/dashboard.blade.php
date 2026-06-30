<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-red-600">Dashboard KDKMP</p>
                <h1 class="text-3xl font-bold text-gray-900">Halo, Operator {{ ucfirst(Auth::user()->role) }}
                <p class="mt-2 text-sm text-gray-500">Lihat ringkasan aktivitas Anda dan akses cepat ke menu penting.</p>
            </div>
            <div class="flex gap-3">
            </div>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_60px_-30px_rgba(239,68,68,0.5)] border border-red-100">
            <p class="text-sm uppercase tracking-[0.28em] text-red-600">Transaksi Keuangan</p>
            <p class="mt-4 text-4xl font-bold text-gray-900">{{ $transactionCount }}</p>
            <p class="mt-2 text-sm text-gray-500">Total transaksi tercatat di sistem.</p>
        </div>

        <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_60px_-30px_rgba(239,68,68,0.5)] border border-red-100">
            <p class="text-sm uppercase tracking-[0.28em] text-red-600">Komoditas Barter</p>
            <p class="mt-4 text-4xl font-bold text-gray-900">{{ $commodityCount }}</p>
            <p class="mt-2 text-sm text-gray-500">Daftar komoditas yang tersedia di sistem.</p>
        </div>

    </div>

    <section class="mt-8 rounded-[36px] bg-white p-6 shadow-[0_18px_60px_-30px_rgba(239,68,68,0.5)] border border-red-100">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Transaksi Terbaru</h2>
                <p class="mt-2 text-sm text-gray-500">Riwayat transaksi terbaru yang telah tercatat di sistem.</p>
            </div>
            <div class="hidden sm:block text-sm font-medium text-red-600">{{ now()->format('d M Y') }}</div>
        </div>

        <div class="mt-6 space-y-4">
            @forelse($recentTransactions as $transaction)
                <div class="rounded-[24px] border border-red-100 p-4 hover:border-red-200 transition">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $transaction->description }}</p>
                            <p class="mt-1 text-sm text-gray-500">{{ $transaction->category }} — {{ $transaction->transaction_date->format('d M Y') }}</p>
                        </div>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                    </div>
                    @if($transaction->note)
                        <p class="mt-3 text-sm text-gray-500">{{ $transaction->note }}</p>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada transaksi. Tambahkan transaksi di halaman Keuangan.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>
