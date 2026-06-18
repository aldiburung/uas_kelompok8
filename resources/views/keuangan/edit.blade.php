<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Transaksi') }}</h2>
            <a href="{{ route('keuangan.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500">Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('keuangan.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid gap-6">
                            <div>
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description', $transaction->description) }}" required autofocus />
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="category" :value="__('Kategori')" />
                                <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach(\App\Models\Transaction::categories() as $category)
                                        <option value="{{ $category }}" {{ old('category', $transaction->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('category')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="amount" :value="__('Jumlah (Rp)')" />
                                <x-text-input id="amount" name="amount" type="number" class="mt-1 block w-full" value="{{ old('amount', $transaction->amount) }}" required />
                                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="transaction_date" :value="__('Tanggal Transaksi')" />
                                <x-text-input id="transaction_date" name="transaction_date" type="date" class="mt-1 block w-full" value="{{ old('transaction_date', $transaction->transaction_date->toDateString()) }}" required />
                                <x-input-error :messages="$errors->get('transaction_date')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="termin_id" :value="__('Termin')" />
                                <select id="termin_id" name="termin_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Pilih Termin --</option>
                                    @foreach(\App\Models\Termin::all() as $termin)
                                        <option value="{{ $termin->id }}" {{ old('termin_id', $transaction->termin_id) == $termin->id ? 'selected' : '' }}>{{ $termin->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('termin_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="note" :value="__('Catatan')" />
                                <textarea id="note" name="note" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('note', $transaction->note) }}</textarea>
                                <x-input-error :messages="$errors->get('note')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('keuangan.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                                <x-primary-button>{{ __('Perbarui Transaksi') }}</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
