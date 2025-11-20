<?php

namespace Database\Seeders;

use App\Models\Cabang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CabangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cabang::insert([
            [
                'kode_cabang' => 'md_mdn',
                'nama_cabang' => 'MD MEDAN',
            ],
            [
                'kode_cabang' => 'md_pku',
                'nama_cabang' => 'MD PEKANBARU',
            ],
            [
                'kode_cabang' => 'batam',
                'nama_cabang' => 'BATAM',
            ],
        ]);
    }
}
