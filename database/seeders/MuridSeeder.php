<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MuridSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $daftarKelas = ['X RPL 1', 'X RPL 2', 'XI TKJ 1', 'XI TKJ 2', 'XII MM 1'];

        // Generate 20 data murid acak
        for ($i = 1; $i <= 20; $i++) {
            DB::table('murid')->insert([
                // NIS maks 4 karakter (format: 1001, 1002, dst.)
                'nis' => (string) (1000 + $i),
                // Nama maks 40 karakter
                'nama' => Str::limit(fake('id_ID')->name(), 40, ''),
                // Kelas maks 10 karakter
                'kelas' => fake()->randomElement($daftarKelas),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
}