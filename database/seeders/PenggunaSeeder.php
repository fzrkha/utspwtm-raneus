<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('pengguna')->insert([
                'id' => $i,
                // NIP 10 digit angka (contoh: 1980120101)
                'nip' => fake()->unique()->numerify('19########'),
                // Nama maks 40 karakter
                'nama' => Str::limit(fake('id_ID')->name(), 40, ''),
                // Username maks 30 karakter
                'username' => Str::limit(fake()->unique()->userName(), 30, ''),
                'password' => Hash::make('password123'),
                // Nomor HP maks 16 karakter
                'telp' => fake()->numerify('08##########'),
                'email' => fake()->unique()->safeEmail(),
                'level' => fake()->randomElement(['administrasi', 'gurubk']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
}