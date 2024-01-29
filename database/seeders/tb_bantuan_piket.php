<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tb_bantuan_piket extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tb_bantuan_piket')->insert([
            [
                'tanggal' 			=> '2023-06-20',
                'piket' 			=> 'A',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'tanggal' 			=> '2023-06-21',
                'piket' 			=> 'B',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'tanggal' 			=> '2023-06-22',
                'piket' 			=> 'C',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'tanggal' 			=> '2023-06-23',
                'piket' 			=> 'A',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'tanggal' 			=> '2023-06-24',
                'piket' 			=> 'B',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ],
            [
                'tanggal' 			=> '2023-06-25',
                'piket' 			=> 'C',
                'created_by'        => 'System',
                'created_at'		=> date('Y-m-d H:i:s')
            ]
        ]);
    }
}
