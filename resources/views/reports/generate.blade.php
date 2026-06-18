<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan Transaksi') }}</h2>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Kembali ke Form</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Laporan Transaksi</h1>

                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded">
                        <p class="text-sm text-gray-600">
                            Periode: <strong>{{ $startDate ? date('d/m/Y', strtotime($startDate)) : 'Awal' }}</strong> s/d <strong>{{ $endDate ? date('d/m/Y', strtotime($endDate)) : 'Akhir' }}</strong>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-green-100 p-4 rounded border border-green-300">
                            <p class="text-gray-600 text-sm">Total Transaksi</p>
                            <p class="text-2xl font-bold text-green-700">{{ $totalTransactions }}</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded border border-blue-300">
                            <p class="text-gray-600 text-sm">Total Jumlah</p>
                            <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded border border-yellow-300">
                            <p class="text-gray-600 text-sm">Rata-rata</p>
                            <p class="text-2xl font-bold text-yellow-700">Rp {{ number_format($totalTransactions ? $totalAmount / $totalTransactions : 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded">
                        <h2 class="text-lg font-semibold mb-3">Ringkasan Kategori</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($categoryTotals as $category => $amount)
                                <div class="bg-white p-4 rounded border border-gray-200">
                                    <p class="text-gray-600 text-sm">{{ ucfirst($category) }}</p>
                                    <p class="text-xl font-bold mt-2">Rp {{ number_format($amount, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Tanggal</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Deskripsi</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Kategori</th>
                                    <th class="border border-gray-300 px-4 py-2 text-left">Termin</th>
                                    <th class="border border-gray-300 px-4 py-2 text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->description }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ ucfirst($transaction->category) }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $transaction->termin?->name ?? '-' }}</td>
                                        <td class="border border-gray-300 px-4 py-2 text-right font-bold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="border border-gray-300 px-4 py-2 text-center text-gray-500">Tidak ada transaksi untuk periode ini</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
