<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Katalog Barter') }}</h2>
            <a href="{{ route('barter.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500">Tambah Komoditas</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
            @endif

            <div class="grid gap-6 md:grid-cols-2">
                @forelse($commodities as $commodity)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $commodity->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Desa: {{ $commodity->village }}</p>
                        <p class="text-sm text-gray-500">Stok: {{ $commodity->stock }} ({{ $commodity->unit }})</p>
                        <p class="text-sm text-gray-500">Estimasi nilai: Rp {{ number_format($commodity->estimated_value, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-700 mt-3">{{ $commodity->description }}</p>
                        <div class="mt-6 flex flex-wrap items-center gap-2">
                            <a href="{{ route('barter.show', ['barter' => $commodity]) }}" class="inline-flex items-center rounded-md bg-blue-500 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-600">Lihat</a>
                            <a href="{{ route('barter.edit', ['barter' => $commodity]) }}" class="inline-flex items-center rounded-md bg-yellow-400 px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-500">Edit</a>
                            <form action="{{ route('barter.destroy', ['barter' => $commodity]) }}" method="POST" class="inline-flex" onsubmit="return confirm('Hapus komoditas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 col-span-full">
                        <p class="text-gray-500">Belum ada komoditas barter. Tambahkan daftar komoditas untuk digunakan dalam sistem barter desa.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $commodities->links() }}</div>
        </div>
    </div>
</x-app-layout>
