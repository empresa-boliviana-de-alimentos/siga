<?php

use Illuminate\Database\Seeder;
use siga\Modelo\insumo\insumo_registros\Partida;

class PartidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partidas = [
            ["part_codigo"=>"31140","part_nombre"=>"ALIMENTACION HOSPITALARIA, PENITENCIARIA, AERONAVES Y OTRAS ESPECIFICAS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31200","part_nombre"=>"ALIMENTOS PARA ANIMALES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31150","part_nombre"=>"ALIMENTOS Y BEBIDAS PARA LA ATENCION DE EMERGENCIAS Y DESASTRES NATURALES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31100","part_nombre"=>"ALIMENTOS Y BEBIDAS PARA PERSONAS, DESAYUNO ESCOLAR Y OTROS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31100","part_nombre"=>"ALIMENTOS Y PRODUCTOS AGROFORESTALES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"33400","part_nombre"=>"CALZADOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34110","part_nombre"=>"COMBUSTIBLES LUBRICANTES Y DERIVADOS PARA CONSUMO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34120","part_nombre"=>"COMBUSTIBLES, LUBRICANTES Y DERIVADOS PARA COMERCIALIZACION","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34100","part_nombre"=>"COMBUSTIBLES, LUBRICANTES, DERIVADOS Y OTRAS FUENTES DE ENERGIA","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34000","part_nombre"=>"COMBUSTIBLES, PRODUCTOS QUIMICOS, FARMACEUTICOS Y OTRAS FUENTES DE ENERGIA","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"33200","part_nombre"=>"CONFECCIONES TEXTILES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31130","part_nombre"=>"DESAYUNO ESCOLAR","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34130","part_nombre"=>"ENERGIA ELECTRICA PARA COMERCIALIZACION","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"43300","part_nombre"=>"EQUIPO DE TRANSPORTE","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31110","part_nombre"=>"GASTOS DESTINADOS AL PAGO DE REFRIGERIOS AL PERSONAL DE LAS INSTITUCIONES PUBLICAS.","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"31120","part_nombre"=>"GASTOS POR ALIMENTACION Y OTROS SIMILARES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34800","part_nombre"=>"HERRAMIENTAS MENORES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"33100","part_nombre"=>"HILADOS Y TELAS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"39400","part_nombre"=>"INSTRUMENTAL MENOR MEDICO-QUIRURGICO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"32300","part_nombre"=>"LIBROS Y REVISTAS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34300","part_nombre"=>"LLANTAS Y NEUMATICOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"39100","part_nombre"=>"MATERIAL DE LIMPIEZA","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"39200","part_nombre"=>"MATERIAL DEPORTIVO Y RECREATIVO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34900","part_nombre"=>"MATERIAL Y EQUIPO MILITAR","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"30000","part_nombre"=>"MATERIALES Y SUMINISTROS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"34700","part_nombre"=>"MINERALES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"43700","part_nombre"=>"OTRO MAQUINARIA Y EQUIPO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"39900","part_nombre"=>"OTROS MATERIALES Y SUMINISTROS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"39800","part_nombre"=>"OTROS REPUESTOS Y ACCESORIOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"32100","part_nombre"=>"PAPEL DE ESCRITORIO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"32500","part_nombre"=>"PERIODICOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
            ["part_codigo"=>"33300","part_nombre"=>"PRENDAS DE VESTIR","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],	
            ["part_codigo"=>"31300","part_nombre"=>"PRODUCTOS AGRICOLAS, PECUARIOS Y FORESTALES","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],	
			["part_codigo"=>"32200","part_nombre"=>"PRODUCTOS DE ARTES GRAFICAS PAPEL Y CARTON","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],	
			["part_codigo"=>"34400","part_nombre"=>"PRODUCTOS DE CUERO Y CAUCHO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"34500","part_nombre"=>"PRODUCTOS DE MINIERALES NO METALICOAS Y PLASTICOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],	
			["part_codigo"=>"32000","part_nombre"=>"PRODUCTOS DE PAPEL, CARTON E IMPRESOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],	
			["part_codigo"=>"34600","part_nombre"=>"PRODUCTOS METALICOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],	
			["part_codigo"=>"34200","part_nombre"=>"PRODUCTOS QUIMICOS Y FARMACEUTICOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"39000","part_nombre"=>"PRODUCTOS VARIOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"33000","part_nombre"=>"TEXTILES Y VESTUARIO","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"32400","part_nombre"=>"TEXTOS DE ENSEÑANZA","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"39300","part_nombre"=>"UTENSILIOS DE COCINA Y COMEDOR","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"39500","part_nombre"=>"UTILES DE ESCRITORIO Y OFICINA","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"39600","part_nombre"=>"UTILES EDUCACIONALES, CULTURALES Y DE CAPACITACION","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],
			["part_codigo"=>"39700","part_nombre"=>"UTILES Y MATERIALES ELECTRICOS","part_usr_id"=>1,"part_registrado"=>Carbon\Carbon::now(),"part_modificado"=>Carbon\Carbon::now()],

        ];
        foreach($partidas as $partida)
        {
            Partida::create($partida);
        }
    }
}
