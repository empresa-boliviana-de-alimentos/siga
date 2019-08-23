<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Usuario extends Model
{
    protected $table      = '_bp_usuarios';
    protected $fillable   = ['usr_id', 'usr_usuario', 'usr_prs_id', 'usr_estado', 'password', 'usr_usr_id','usr_linea_trabajo','usr_planta_id','usr_zona_id', 'usr_id_turno'];
    protected $primaryKey = 'usr_id';
    public $timestamps    = false;
    protected static function getListar()
    {
        $usr = Usuario::join('_bp_personas', '_bp_usuarios.usr_prs_id', '=', '_bp_personas.prs_id')
	    ->join('_bp_planta', '_bp_usuarios.usr_planta_id', '=', '_bp_planta.id_planta')
            ->where('_bp_usuarios.usr_estado', 'A')
            ->get();
        return $usr;
    }
    protected static function setBuscar($id)
    {
        $respuesta = Usuario::where('usr_id', $id)->where('usr_estado', 'A')->first();
        return $respuesta;
    }
    protected static function getEstado()
    {
        $usuario=Usuario::where('_bp_usuarios.usr_estado', 'A')
            ->get();
        return $usuario;
    }
    protected static function setDestroy($id)
    {
        $usuario = Usuario::where('usr_id', $id)
            ->update(['usr_estado' => 'B']);
        return $usuario;
    }
    protected static function setNombre($id)
   {
       $repeaters = \DB::table('acopio.acopio')
               ->join('public._bp_usuarios', 'acopio.acopio.aco_id_usr', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->where('acopio.acopio.aco_id', $id)
               ->first();
       return $repeaters;
   }

  protected static function setNombreFru($id)
   {
       $repeaters = \DB::table('acopio.det_acop_ca')
               ->join('public._bp_usuarios', 'acopio.det_acop_ca.dac_id_rec', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->where('acopio.det_acop_ca.dac_id', $id)
               ->first();
       return $repeaters;
   }

    protected static function setNombreRegistro()
   {
       //$id =  Auth::user()->usr_id;
       $registro = \DB::table('insumo.carro_ingreso')
               ->join('public._bp_usuarios', 'insumo.carro_ingreso.carr_ing_usr_id', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               //->where('carr_ing_usr_id',$id)
               //->where('acopio.acopio.aco_id', $id)
               ->first();
       return $registro;
   }


}
