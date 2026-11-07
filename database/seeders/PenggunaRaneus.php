<?php

namespace Database\Seeders;

use App\Models\Pengguna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenggunaRaneus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            [
                'nip' => '2026010000',
                'nama' => 'Raneus',
                'username' => 'raneus',
                'password' => bcrypt('iniraneus'),
                'telp' => '080000000000',
                'email' => 'raneus-team@gmail.com',
                'level' => 'administrasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '2026020362',
                'nama' => 'Fansoli',
                'username' => 'fnsoli',
                'password' => bcrypt('ada'),
                'telp' => '089678012718',
                'email' => '2411500362@student.budiluhur.ac.id',
                'level' => 'gurubk',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '2026031121',
                'nama' => 'Jasmine',
                'username' => 'jsmine',
                'password' => bcrypt('himineon'),
                'telp' => '080000000000',
                'email' => '2411501121@student.budiluhur.ac.id',
                'level' => 'gurubk',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nip' => '2026040000',
                'nama' => 'Raka',
                'username' => 'raka',
                'password' => bcrypt('raka'),
                'telp' => '080000000000',
                'email' => 'example@email.com',
                'level' => 'administrasi',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach($users as $key=>$val){
            Pengguna::create($val);
        }
    }
}
