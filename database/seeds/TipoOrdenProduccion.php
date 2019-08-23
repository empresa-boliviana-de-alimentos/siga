<?php

use Illuminate\Database\Seeder;

class TipoOrdenProduccion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insumo.tipo_orden_produccion')->insert([
            'tiporprod_nombre' =>  'SOLICITUD ORDEN PRODUCCION',
        ]);
        DB::table('insumo.tipo_orden_produccion')->insert([
            'tiporprod_nombre' =>  'SOLICITUD INSUMO ADICIONAL',
        ]);
        DB::table('insumo.tipo_orden_produccion')->insert([
            'tiporprod_nombre' =>  'SOLICITUD TRASPASO',
        ]);
        DB::table('insumo.tipo_orden_produccion')->insert([
            'tiporprod_nombre' =>  'SOLICITUD MAQUILA',
        ]);
    }
}
