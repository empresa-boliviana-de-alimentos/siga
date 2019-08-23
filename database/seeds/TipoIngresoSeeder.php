<?php

use Illuminate\Database\Seeder;

class TipoIngresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('insumo.tipo_ingreso')->insert([
            'ting_nombre' 	=>  'INGRESO',
            'ting_usr_id'	=>  3,
            'ting_registrado' => Carbon\Carbon::now(),
            'ting_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.tipo_ingreso')->insert([
            'ting_nombre' 	=>  'MATERIA PRIMA',
            'ting_usr_id'	=>  3,
            'ting_registrado' => Carbon\Carbon::now(),
            'ting_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.tipo_ingreso')->insert([
            'ting_nombre'   =>  'DEVOLUCION SOBRANTE',
            'ting_usr_id'   =>  3,
            'ting_registrado' => Carbon\Carbon::now(),
            'ting_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.tipo_ingreso')->insert([
            'ting_nombre'   =>  'TRASPASO',
            'ting_usr_id'   =>  3,
            'ting_registrado' => Carbon\Carbon::now(),
            'ting_modificado' => Carbon\Carbon::now(),
        ]);
    }
}
