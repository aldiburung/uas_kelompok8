<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Komoditas Barter') }}</h2>
            <a href="{{ route('barter.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('barter.update', $commodity) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-6">
                            <div>
                                <x-input-label for="name" :value="__('Nama Komoditas')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $commodity->name) }}" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="village" :value="__('Desa / Desa Asal')" />
                                <x-text-input id="village" name="village" type="text" class="mt-1 block w-full" value="{{ old('village', $commodity->village) }}" required />
                                <x-input-error :messages="$errors->get('village')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="unit" :value="__('Satuan')" />
                                <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" value="{{ old('unit', $commodity->unit) }}" required />
                                <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="stock" :value="__('Jumlah Stok')" />
                                <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" value="{{ old('stock', $commodity->stock) }}" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="estimated_value" :value="__('Estimasi Nilai (Rp)')" />
                                <x-text-input id="estimated_value" name="estimated_value" type="number" class="mt-1 block w-full" value="{{ old('estimated_value', $commodity->estimated_value) }}" required />
                                <x-input-error :messages="$errors->get('estimated_value')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Deskripsi Tambahan')" />
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $commodity->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('barter.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                                <x-primary-button>{{ __('Perbarui Komoditas') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
