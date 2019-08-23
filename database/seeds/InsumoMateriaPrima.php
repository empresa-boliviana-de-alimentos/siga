<?php

use Illuminate\Database\Seeder;

class InsumoMateriaPrima extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insumo.insumo')->insert([
            'ins_codigo' =>  'MAP-1',
            'ins_enumeracion' =>  1,
            'ins_id_tip_ins' => 3,
            'ins_id_part' => 1,
            'ins_id_uni' => 2,
            'ins_desc' => 'LECHE',
            'ins_usr_id' => 1,
            'ins_id_planta' => 1,
        ]);
        DB::table('insumo.insumo')->insert([
            'ins_codigo' =>  'MAP-2',
            'ins_enumeracion' =>  2,
            'ins_id_tip_ins' => 3,
            'ins_id_part' => 1,
            'ins_id_uni'  => 1,
            'ins_desc' => 'ALMENDRA',
            'ins_usr_id' => 1,
            'ins_id_planta' => 1,
        ]);
    }

 
}
