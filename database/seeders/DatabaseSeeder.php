<?php

namespace Database\Seeders;

use App\Models\Commodity;
use App\Models\Termin;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Termins
        $kontap = Termin::firstOrCreate([
            'name' => 'Kontap',
        ], [
            'description' => 'Pembayaran secara kontap/tunai',
        ]);

        $hari30 = Termin::firstOrCreate([
            'name' => '30 Hari',
        ], [
            'description' => 'Pembayaran dalam waktu 30 hari',
        ]);

        $hari60 = Termin::firstOrCreate([
            'name' => '60 Hari',
        ], [
            'description' => 'Pembayaran dalam waktu 60 hari',
        ]);

        // Create Users with simplified roles
        $keuangan = User::firstOrCreate([
            'email' => 'keuangan@example.com',
        ], [
            'name' => 'User Keuangan',
            'role' => 'keuangan',
            'password' => bcrypt('password'),
        ]);

        $barter = User::firstOrCreate([
            'email' => 'barter@example.com',
        ], [
            'name' => 'User Barter',
            'role' => 'barter',
            'password' => bcrypt('password'),
        ]);

        // Create Transactions
        Transaction::firstOrCreate([
            'user_id' => $keuangan->id,
            'description' => 'Pembelian bahan baku pertanian',
            'transaction_date' => now()->subDays(3)->toDateString(),
        ], [
            'category' => 'Material',
            'termin_id' => $kontap->id,
            'amount' => 750000,
            'note' => 'Pengeluaran untuk pupuk dan bibit.',
        ]);

        Transaction::firstOrCreate([
            'user_id' => $keuangan->id,
            'description' => 'Penerimaan hasil panen padi',
            'transaction_date' => now()->subDays(1)->toDateString(),
        ], [
            'category' => 'Operasional',
            'termin_id' => $kontap->id,
            'amount' => 2500000,
            'note' => 'Penjualan hasil panen ke pedagang lokal.',
        ]);

        // Create Commodities
        Commodity::firstOrCreate([
            'user_id' => $barter->id,
            'name' => 'Beras Lokal',
        ], [
            'village' => 'Desa Salawana',
            'unit' => 'kg',
            'stock' => 120,
            'estimated_value' => 1800000,
            'description' => 'Beras kualitas medium siap barter dengan ikan atau garam.',
        ]);

        Commodity::firstOrCreate([
            'user_id' => $barter->id,
            'name' => 'Ikan Segar',
        ], [
            'village' => 'Desa Pantai Indah',
            'unit' => 'kg',
            'stock' => 50,
            'estimated_value' => 900000,
            'description' => 'Ikan tangkapan segar dari laut, cocok untuk ditukar dengan beras atau telur.',
        ]);

        Commodity::firstOrCreate([
            'user_id' => $barter->id,
            'name' => 'Garam Rakyat',
        ], [
            'village' => 'Desa Pantai Bersih',
            'unit' => 'kg',
            'stock' => 200,
            'estimated_value' => 1200000,
            'description' => 'Garam berkualitas tinggi, siap barter dengan komoditas lainnya.',
        ]);

        // Ensure there is at least one commodity owned by the keuangan user so barter requests can target it
        Commodity::firstOrCreate([
            'user_id' => $keuangan->id,
            'name' => 'Pupuk Organik',
        ], [
            'village' => 'Desa Sawah Makmur',
            'unit' => 'kg',
            'stock' => 80,
            'estimated_value' => 400000,
            'description' => 'Pupuk organik berkualitas untuk kebutuhan pertanian, siap ditukar dengan komoditas lokal.',
        ]);
    }
}
