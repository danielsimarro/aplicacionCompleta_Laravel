<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Coche extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //guardar 100 registros
        $arrays = range(0,100);
        foreach ($arrays as $valor) {
          DB::table('coche')->insert([	            
              'marca' => Str::random(10),
              'modelo' => Str::random(10),
              'color' => Str::random(10),
              'precio' => rand(1, 50000),
          ]);
        }
    }
}
