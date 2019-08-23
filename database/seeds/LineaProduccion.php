<?php

use Illuminate\Database\Seeder;

class LineaProduccion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insumo.linea_produccion')->insert([
            'linea_prod_nombre'	=>  'LACTEOS',
            'linea_prod_usr_id'	=>  3,
            'linea_prod_registrado' => Carbon\Carbon::now(),
            'linea_prod_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.linea_produccion')->insert([
            'linea_prod_nombre'	=>  'ALMENDRA',
            'linea_prod_usr_id'	=>  3,
            'linea_prod_registrado' => Carbon\Carbon::now(),
            'linea_prod_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.linea_produccion')->insert([
            'linea_prod_nombre'	=>  'MIEL',
            'linea_prod_usr_id'	=>  3,
            'linea_prod_registrado' => Carbon\Carbon::now(),
            'linea_prod_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.linea_produccion')->insert([
            'linea_prod_nombre'	=>  'FRUTOS',
            'linea_prod_usr_id'	=>  3,
            'linea_prod_registrado' => Carbon\Carbon::now(),
            'linea_prod_modificado' => Carbon\Carbon::now(),
        ]);
        DB::table('insumo.linea_produccion')->insert([
            'linea_prod_nombre'	=>  'DERIVADOS',
            'linea_prod_usr_id'	=>  3,
            'linea_prod_registrado' => Carbon\Carbon::now(),
            'linea_prod_modificado' => Carbon\Carbon::now(),
        ]);
    }
}
