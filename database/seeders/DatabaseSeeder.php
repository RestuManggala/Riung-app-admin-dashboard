<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Jabatan;
use App\Models\RekeningKoran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345'),
            'jabatan_id' => 1,
        ]);

        $level = [
            [
                "jabatan" => "Bos",
            ],
            [
                "jabatan" => "Staff",
            ]
        ];

        foreach ($level as $key => $value) {
            Jabatan::create($value);
        }

        $rekeningKorans = [
            [
                "nama_bank" => "Bank Jabar Banten Syariah",
                "kode_rekening" => "BJBS4690",
                "pdf" => "",
            ],
            [
                "nama_bank" => "Bank Negara Indonesia",
                "kode_rekening" => "BNI2454",
                "pdf" => "",
            ],
            [
                "nama_bank" => "Bank Syariah Indonesia",
                "kode_rekening" => "BSI4797",
                "pdf" => "",
            ],
            [
                "nama_bank" => "Bank Syariah Indonesia",
                "kode_rekening" => "BSI0020",
                "pdf" => "",
            ],
            [
                "nama_bank" => "Bank Mandiri",
                "kode_rekening" => "MANDIRI7210",
                "pdf" => "",
            ],
        ];

        foreach ($rekeningKorans as $key => $value) {
            RekeningKoran::create($value);
        }
    }
}
