<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan') }}</h2>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Segarkan</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Laporan Transaksi Keuangan</h1>

                    <form action="{{ route('reports.generate') }}" method="POST" class="mb-6 space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tanggal Mulai</label>
                                <input type="date" name="start_date" class="w-full px-4 py-2 border border-gray-300 rounded" value="{{ old('start_date', request('start_date')) }}">
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tanggal Akhir</label>
                                <input type="date" name="end_date" class="w-full px-4 py-2 border border-gray-300 rounded" value="{{ old('end_date', request('end_date')) }}">
                            </div>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buat Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

