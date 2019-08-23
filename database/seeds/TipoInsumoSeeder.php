<?php

use Illuminate\Database\Seeder;

class TipoInsumoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('insumo.tipo_insumo')->insert([
            'tins_nombre' =>  'INSUMO',
            'tins_usr_id' =>  1,
            'tins_registrado' => Carbon\Carbon::now(),
            'tins_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.tipo_insumo')->insert([
            'tins_nombre' =>  'ENVASE',
            'tins_usr_id' =>  1,
            'tins_registrado' => Carbon\Carbon::now(),
            'tins_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.tipo_insumo')->insert([
            'tins_nombre' =>  'MATERIA PRIMA',
            'tins_usr_id' =>  1,
            'tins_registrado' => Carbon\Carbon::now(),
            'tins_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.tipo_insumo')->insert([
            'tins_nombre' =>  'SABORIZANTE',
            'tins_usr_id' =>  1,
            'tins_registrado' => Carbon\Carbon::now(),
            'tins_modificado' => Carbon\Carbon::now(),
        ]);
    }
}
