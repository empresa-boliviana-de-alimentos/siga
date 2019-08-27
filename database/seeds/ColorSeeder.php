<?php

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insumo.color')->insert([
            'col_nombre'	 =>  'NO CUENTA',
            'col_usr_id'	 => 1,
            'col_registrado' => Carbon\Carbon::now(),
            'col_modificado' => Carbon\Carbon::now(),
        ]);
    }
}
