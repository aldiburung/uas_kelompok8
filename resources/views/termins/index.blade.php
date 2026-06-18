<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Termin') }}</h2>
            <a href="{{ route('termins.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">Tambah Termin</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-700">{{ session('success') }}</div>
                    @endif

                    @if($termins->isEmpty())
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-6 text-gray-600">Belum ada termin. Silakan tambah termin baru.</div>
                    @else
                        <div class="space-y-4">
                            @foreach($termins as $termin)
                                <div class="rounded-lg border border-gray-200 p-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $termin->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $termin->description ?? 'Tidak ada deskripsi.' }}</p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('termins.edit', $termin) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                            <form action="{{ route('termins.destroy', $termin) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus termin ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>