<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detail Komoditas') }}</h2>
            <a href="{{ route('barter.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Nama Komoditas</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $commodity->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Desa / Desa Asal</label>
                            <p class="mt-1 text-gray-600">{{ $commodity->village }}</p>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Satuan</label>
                                <p class="mt-1 text-gray-600">{{ $commodity->unit }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Jumlah Stok</label>
                                <p class="mt-1 text-gray-600">{{ $commodity->stock }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700">Estimasi Nilai</label>
                                <p class="mt-1 text-gray-600">Rp {{ number_format($commodity->estimated_value, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700">Deskripsi</label>
                            <p class="mt-1 text-gray-600">{{ $commodity->description ?: 'Tidak ada deskripsi' }}</p>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t">
                            <a href="{{ route('barter.edit', $commodity) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">Edit</a>
                            <form action="{{ route('barter.destroy', $commodity) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komoditas ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
