<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Admin::create([
            'name'          => 'Admin Pak Tani',
            'email'         => 'admin',
            'password'      => bcrypt('massalman' . '<4d[M!n}'),
            'is_active'     => 1
        ]);

        \App\Admin::create([
            'name'          => 'Coba Admin',
            'email'         => 'coba_admin',
            'password'      => bcrypt('ptn' . '<4d[M!n}'),
            'is_active'     => 1
        ]);

        \App\Cashier::create([
            'name'          => 'Cashier Pak Tani',
            'email'         => 'cashier',
            'password'      => bcrypt('massalman' . 'k&4z~1e1R*'),
            'is_active'     => 1
        ]);

        \App\Cashier::create([
            'name'          => 'Coba Cashier',
            'email'         => 'coba_cashier',
            'password'      => bcrypt('ptn' . 'k&4z~1e1R*'),
            'is_active'     => 1
        ]);

        DB::table('members')->insert(array(
            array('name' => 'Non Member', 'address' => 'Demak'),
        ));

        DB::table('accounts')->insert(array(
            array('code' => '1111', 'name' => 'Kas di Tangan', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            // array('code' => '1112', 'name' => 'Kas di Bank', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1131', 'name' => 'Piutang Dagang', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1132', 'name' => 'Cadangan Kerugian Piutang', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1133', 'name' => 'Piutang Karyawan', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1134', 'name' => 'Piutang Lain-lain', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1141', 'name' => 'Persediaan Barang', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1151', 'name' => 'Persekot Biaya Perjalanan', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1201', 'name' => 'Investasi Jangka Panjang', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1311', 'name' => 'Tanah', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1312', 'name' => 'Peralatan Toko', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1313', 'name' => 'Kendaraan', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1322', 'name' => 'Akumulasi Penyusutan Peralatan Toko', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '1323', 'name' => 'Akumulasi Penyusutan Kendaraan', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            array('code' => '2101', 'name' => 'Utang Dagang', 'type' => 'Kredit', 'group' => 'Neraca', 'activa' => 'pasiva'),
            array('code' => '2102', 'name' => 'Utang Gaji', 'type' => 'Kredit', 'group' => 'Neraca', 'activa' => 'pasiva'),
            array('code' => '2104', 'name' => 'Utang Jangka Pendek Lain-lain', 'type' => 'Kredit', 'group' => 'Neraca', 'activa' => 'pasiva'),
            array('code' => '3001', 'name' => 'Modal Pemilik', 'type' => 'Kredit', 'group' => 'Neraca', 'activa' => 'pasiva'),
            array('code' => '3002', 'name' => 'Laba Periode Berjalan', 'type' => 'Kredit', 'group' => 'Neraca', 'activa' => 'pasiva'),
            array('code' => '4101', 'name' => 'Penjualan', 'type' => 'Kredit', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5101', 'name' => 'Harga Pokok Penjualan', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5211', 'name' => 'Biaya Gaji', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5212', 'name' => 'Biaya Pemasaran', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5213', 'name' => 'Biaya Penyusutan Peralatan Toko', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5214', 'name' => 'Biaya Pengiriman', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5215', 'name' => 'Biaya Penyusutan Barang', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5216', 'name' => 'Biaya Sewa', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5217', 'name' => 'Biaya Penyusutan Kendaraan', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5218', 'name' => 'Biaya Perjalanan', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5219', 'name' => 'Biaya Uang Hilang', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5220', 'name' => 'Biaya Operasional Toko', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5221', 'name' => 'Biaya Charity', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '5222', 'name' => 'Biaya Zakat', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '6101', 'name' => 'Pendapatan Lain-lain', 'type' => 'Kredit', 'group' => 'Laba Rugi', 'activa' =>''),
            array('code' => '6102', 'name' => 'Biaya Lain-lain', 'type' => 'Debet', 'group' => 'Laba Rugi', 'activa' =>''),
            // array('code' => '1113', 'name' => 'Kas di Nanang', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
            // array('code' => '1114', 'name' => 'Kas Uang Tukar', 'type' => 'Debet', 'group' => 'Neraca', 'activa' => 'aktiva'),
        ));

        DB::table('colors')->insert(array(
            array('code' => 'NONE', 'name' => 'Tidak ada warna', 'eng_name' => 'None', 'hex' => '#FFFFFF'),
            array('code' => 'BLK', 'name' => 'Hitam', 'eng_name' => 'Black', 'hex' => '#000000'),
            array('code' => 'RED', 'name' => 'Merah', 'eng_name' => 'Red', 'hex' => '#FF0000'),
            array('code' => 'PIN', 'name' => 'Pink', 'eng_name' => 'Pink', 'hex' => '#FFC0CB'),
            array('code' => 'WHT', 'name' => 'Putih', 'eng_name' => 'White', 'hex' => '#FFFFFF'),
            array('code' => 'BLU', 'name' => 'Biru', 'eng_name' => 'Blue', 'hex' => '#0000FF'),
            array('code' => 'LBL', 'name' => 'Biru muda', 'eng_name' => 'Light Blue', 'hex' => '#44e0f6'),
            array('code' => 'DBL', 'name' => 'Biru tua', 'eng_name' => 'Dark Blue', 'hex' => '#000dc7'),
            array('code' => 'GRE', 'name' => 'Hijau', 'eng_name' => 'Green', 'hex' => '#06870e'),
            array('code' => 'LGR', 'name' => 'Hijau muda', 'eng_name' => 'Light Green', 'hex' => '#49f254'),
            array('code' => 'DGR', 'name' => 'Hijau tua', 'eng_name' => 'Dark Green', 'hex' => '#014905'),
            array('code' => 'ORE', 'name' => 'Jingga', 'eng_name' => 'Orange', 'hex' => '#eeb13e'),
            array('code' => 'BRW', 'name' => 'Coklat', 'eng_name' => 'Brown', 'hex' => '#563904'),
            array('code' => 'LBR', 'name' => 'Coklat muda', 'eng_name' => 'Light Brown', 'hex' => '#c39948'),
            array('code' => 'DBR', 'name' => 'Coklat tua', 'eng_name' => 'Dark Brown', 'hex' => '#362300'),
            array('code' => 'GRY', 'name' => 'Abu-abu', 'eng_name' => 'Gray', 'hex' => '#94928e'),
            array('code' => 'PUR', 'name' => 'Ungu', 'eng_name' => 'Purple', 'hex' => '#bd00ff'),
            array('code' => 'MRO', 'name' => 'Merah marun', 'eng_name' => 'Maroon', 'hex' => '#800000'),
            array('code' => 'TOS', 'name' => 'Tosca', 'eng_name' => 'Tosca', 'hex' => '#1edf8c'),
            array('code' => 'VIO', 'name' => 'Violet', 'eng_name' => 'Violet', 'hex' => '#1edf8c'),
            array('code' => 'YEL', 'name' => 'Kuning', 'eng_name' => 'Yellow', 'hex' => '#1edf8c'),
            array('code' => 'GLD', 'name' => 'Emas', 'eng_name' => 'Gold', 'hex' => '#1edf8c'),
            array('code' => 'RBW', 'name' => 'Warna-warni', 'eng_name' => 'Rainbow', 'hex' => '#e59736'),
            array('code' => 'MRN', 'name' => 'Merah marun', 'eng_name' => 'Maroon', 'hex' => '#e59736'),
        ));

        DB::table('units')->insert(array(
            array('code' => 'PCS', 'name' => '1 pcs', 'eng_name' => 'Pieces', 'quantity' => 1, 'base' => 'pcs'),
        ));

        DB::table('categories')->insert(array(
            array('code' => 'CC', 'name' => 'Cincin', 'eng_name' => 'Ring', 'unit_id' => 1),
            array('code' => 'KL', 'name' => 'Kalung', 'eng_name' => 'Necklace', 'unit_id' => 1),
            array('code' => 'GL', 'name' => 'Gelang', 'eng_name' => 'Bracelet', 'unit_id' => 1),
            array('code' => 'AT', 'name' => 'Anting-anting', 'eng_name' => 'Earrings', 'unit_id' => 1),
            array('code' => 'LM', 'name' => 'Emas Murni', 'eng_name' => 'Pure Gold', 'unit_id' => 1),
            array('code' => 'LT', 'name' => 'Liontin', 'eng_name' => 'Liontin', 'unit_id' => 1),
            array('code' => 'OT', 'name' => 'Lain-lain', 'eng_name' => 'Others', 'unit_id' => 1),
        ));

        DB::table('percentages')->insert(array(
            array('name' => '750/17K', 'nominal' => '0.4'),
            // array('name' => '80', 'nominal' => ''),
            array('name' => '875/21K', 'nominal' => '0.6'),
            array('name' => '916/22K', 'nominal' => '0.75'),
            array('name' => '999/24K', 'nominal' => '1'),
        ));
    }
}
