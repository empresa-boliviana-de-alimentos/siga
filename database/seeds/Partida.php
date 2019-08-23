<?php

use Illuminate\Database\Seeder;

class Partida extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('insumo.partida')->insert([
            'part_codigo'   => '1111',
            'part_nombre' 	=>  'PARTIDA MATERIA PRIMA',
            'part_usr_id'	=>  3,
            'part_registrado' => Carbon\Carbon::now(),
            'part_modificado' => Carbon\Carbon::now(),
        ]);
    }
}
