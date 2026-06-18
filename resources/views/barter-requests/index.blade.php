<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pencatatan Transaksi Barter') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h1 class="text-3xl font-bold">Riwayat Transaksi Barter</h1>
                            <p class="text-sm text-gray-600 mt-1">Catat transaksi barter selesai dan lihat riwayat transaksi Anda di sini.</p>
                        </div>
                        <a href="{{ route('barter-requests.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">+ Catat Transaksi Baru</a>
                    </div>

                    <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 p-4 text-blue-700">
                        <p class="text-sm">Panduan:</p>
                        <ol class="list-decimal list-inside text-sm space-y-1">
                            <li>Klik "Catat Transaksi Baru" untuk memilih komoditas dari pengguna lain.</li>
                            <li>Masukkan jumlah dan catatan transaksi jika diperlukan.</li>
                            <li>Transaksi yang tersimpan akan langsung mengurangi stok komoditas yang dipilih.</li>
                        </ol>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        @forelse($transactions as $transaction)
                            <div class="border border-gray-300 rounded p-4 hover:bg-gray-50">
                                <div class="flex flex-col md:flex-row md:justify-between gap-4">
                                    <div>
                                        <p class="font-bold text-lg">{{ $transaction->commodity->name }} ({{ $transaction->commodity->unit }})</p>
                                        <p class="text-sm text-gray-600">Jumlah: <strong>{{ $transaction->quantity }}</strong></p>
                                        <p class="text-sm text-gray-600">Dari: <strong>{{ $transaction->targetUser->name }}</strong></p>
                                        @if($transaction->notes)
                                            <p class="text-sm text-gray-600">Catatan: {{ $transaction->notes }}</p>
                                        @endif
                                    </div>

                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">{{ $transaction->created_at->format('d M Y H:i') }}</p>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-white text-xs {{ $transaction->status === 'accepted' ? 'bg-green-500' : ($transaction->status === 'rejected' ? 'bg-red-500' : 'bg-yellow-500') }} mt-2">{{ $transaction->status === 'accepted' ? 'Selesai' : ucfirst($transaction->status) }}</span>
                                        <div class="mt-2">
                                            <form action="{{ route('barter-requests.destroy', $transaction) }}" method="POST" class="inline" onsubmit="return confirm('Hapus catatan transaksi barter ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-gray-700">
                                Belum ada catatan transaksi barter. Mulai dengan mencatat transaksi baru.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

