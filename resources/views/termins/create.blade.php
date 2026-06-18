<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tambah Termin') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Tambah Termin Baru</h1>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('termins.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Nama Termin</label>
                            <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" value="{{ old('name') }}" required>
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi</label>
                            <textarea name="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('description') }}</textarea>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                            <a href="{{ route('termins.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
