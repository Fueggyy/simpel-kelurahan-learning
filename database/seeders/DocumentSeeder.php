<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document')->updateOrInsert([
            'name' => 'Kartu Tanda Penduduk',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('document')->updateOrInsert([
            'name' => 'Kartu Keluarga',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('document')->updateOrInsert([
            'name' => 'Surat Nikah',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('document')->updateOrInsert([
            'name' => 'Surat Domisili',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

    }
}
