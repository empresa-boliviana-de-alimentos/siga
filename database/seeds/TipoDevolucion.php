<?php

use Illuminate\Database\Seeder;

class TipoDevolucion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insumo.tipo_devolucion')->insert([
            'tipodevo_nombre' 	=>  'SOBRANTE',
        ]);
        DB::table('insumo.tipo_devolucion')->insert([
            'tipodevo_nombre' 	=>  'DEFECTUOSO',
        ]);
    }
}
