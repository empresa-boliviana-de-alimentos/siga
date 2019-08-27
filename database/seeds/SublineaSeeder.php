<?php

use Illuminate\Database\Seeder;

class SublineaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insumo.sub_linea')->insert([
            'sublin_nombre'		=>  'NO CUENTA',
            'sublin_prod_id'	=>  3,
            'sublin_usr_id'		=> 1,
            'sublin_registrado' => Carbon\Carbon::now(),
            'sublin_modificado' => Carbon\Carbon::now(),
        ]);
    }
}
