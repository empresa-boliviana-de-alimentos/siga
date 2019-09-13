<?php

use Illuminate\Database\Seeder;
use siga\Modelo\insumo\insumo_registros\Sabor;

class SaborSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sabores = [
            ["sab_nombre"=>"NO CUENTA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"COCO","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"CHOCOLATE","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"DURAZNO","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"FRAMBUESA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"FRUTILLA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"FRUTILLA Y REMOLACHA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"LIMON","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"MAIZ","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"MANZANA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"MANZANILLA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"MARACUYA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"MORA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"NARANJA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"PERA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"PIÑA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"PLATANO","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"QUINUA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"SOYA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"TRIGO","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"UVA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
            ["sab_nombre"=>"UVA MORADA","sab_usr_id"=>1,"sab_registrado"=>Carbon\Carbon::now(),"sab_modificado"=>Carbon\Carbon::now()],
        ];
        foreach($sabores as $sabor)
        {
            Sabor::create($sabor);
        }
    }
}
