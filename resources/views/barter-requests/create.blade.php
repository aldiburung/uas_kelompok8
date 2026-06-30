<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pencatatan Transaksi Barter') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Catat Transaksi Barter</h1>
                    <div class="mb-4 rounded-lg border border-blue-200 bg-blue-50 p-4 text-blue-700">
                        <p class="text-sm">Pilih komoditas Anda yang ingin dicatat sebagai transaksi barter internal.</p>
                    </div>

                   @if(session('error'))
    <div class="bg-red-500 text-white p-4 rounded-xl mb-4">
        {{ session('error') }}
    </div>
@endif

                    <form action="{{ route('barter-requests.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Pilih Komoditas</label>
                            @if($commodities->isEmpty())
                                <div class="rounded-lg border border-yellow-300 bg-yellow-50 p-4 text-yellow-700">
                                    Belum ada komoditas yang tersedia untuk dicatat. Silakan tambahkan komoditas terlebih dahulu.
                                </div>
                            @else
                                <select name="commodity_id" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                                    <option value="">-- Pilih Komoditas --</option>
                                    @foreach($commodities as $commodity)
                                        <option value="{{ $commodity->id }}">{{ $commodity->name }} ({{ $commodity->unit }}) - {{ $commodity->user->name }} (Stok: {{ $commodity->stock }})</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Catatan</label>
                            <textarea name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" placeholder="Contoh: Transaksi barter untuk pupuk organik...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end">
                            <div class="w-full sm:w-1/3">
                                <label class="block text-gray-700 font-bold mb-2">Jumlah</label>
                                <input type="number" name="quantity" min="1" value="{{ old('quantity', 1) }}" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" {{ $commodities->isEmpty() ? 'disabled' : '' }}>Simpan Transaksi</button>
                                <a href="{{ route('barter-requests.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
