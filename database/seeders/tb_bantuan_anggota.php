<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tb_bantuan_anggota extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_bantuan_anggota')->insert([
            [
                'nama' 			    => 'Iman',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'A',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Maulana',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'B',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Agus',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'C',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Adon',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'A',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Adi',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'B',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Zaki',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'C',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Yoga',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'A',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Budi',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'B',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'nama' 			    => 'Yuda',
                'jabatan' 			=> 'Anggota',
                'piket' 			=> 'C',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ]
        ]);
    }
}
