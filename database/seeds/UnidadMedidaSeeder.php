<?php

use Illuminate\Database\Seeder;
use siga\Modelo\insumo\insumo_registros\UnidadMedida;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = [
            ["umed_nombre"=>"BOLSA","umed_sigla"=>"BOLSA","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"CAJA","umed_sigla"=>"CAJA","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"FRASCO","umed_sigla"=>"FRASCO","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"HOJA","umed_sigla"=>"HOJA","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"JUEGO","umed_sigla"=>"JUEGO", "umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"KILO","umed_sigla"=>"KG","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"LITRO","umed_sigla"=>"lt","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"METRO","umed_sigla"=>"m","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"METRO CÚBICO","umed_sigla"=>"m3","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"PAQUETE","umed_sigla"=>"PAQUETE","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"PAR","umed_sigla"=>"PAR ", "umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"PIEZA","umed_sigla"=>"PIEZA", "umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"UNIDAD","umed_sigla"=>"u","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"ROLLO","umed_sigla"=>"ROLLO", "umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"CENTIMETRO","umed_sigla"=>"cm", "umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"METRO CUADRADO","umed_sigla"=>"m2","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
            ["umed_nombre"=>"PIE TABLAR","umed_sigla"=>"PIE TABLAR","umed_usr_id"=>1,"umed_registrado"=>Carbon\Carbon::now(),"umed_modificado"=>Carbon\Carbon::now()],
        ];
        foreach($unidades as $unidad)
        {
            UnidadMedida::create($unidad);
        }
    }
}
