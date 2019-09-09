<?php

use Illuminate\Database\Seeder;

class DepartamentoComercialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'LA PAZ',
            'depto_abreviatura' => 'LP',
        ]);
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'ORURO',
            'depto_abreviatura' => 'OR',
        ]);  
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'POTOSI',
            'depto_abreviatura' => 'PT',
        ]); 
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'TARIJA',
            'depto_abreviatura' => 'TJ',
        ]);
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'SANTA CRUZ',
            'depto_abreviatura' => 'SC',
        ]);
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'COCHABAMBA',
            'depto_abreviatura' => 'CB',
        ]);
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'BENI',
            'depto_abreviatura' => 'BN',
        ]);
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'PANDO',
            'depto_abreviatura' => 'PA',
        ]);
        DB::table('comercial.departamento_comercial')->insert([
            'depto_nombre' =>  'CHUQUISACA',
            'depto_abreviatura' => 'CH',
        ]);            
    }
}
