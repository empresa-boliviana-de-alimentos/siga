<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Insumo extends Model
{
    protected $table = 'insumo.insumo';

    protected $fillable = [
        'ins_id',
        'ins_codigo',
        //'ins_id_tip_art',
        'ins_enumeracion',
        'ins_id_tip_ins',
        'ins_id_tip_env',
        'ins_id_part',
        //'ins_id_cat',
        'ins_id_uni',
        'ins_desc',
        'ins_usr_id',
        'ins_registrado',
        'ins_modificado',
        'ins_estado',
        'ins_id_planta',
        'ins_id_mercado',
        'ins_id_sabor',
        'ins_id_color',
        'ins_id_municipio',
        'ins_id_linea_prod',
        'ins_peso_presen',
        'ins_formato',
        'ins_id_prod_especi'
    ];
    protected $primaryKey = 'ins_id';

    public $timestamps = false;

    protected static function getListar()
    {
        /*$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
        $usr = Auth::user()->usr_id;
        $insumo = Insumo::join('insumo.dato as dat','insumo.insumo.ins_id_tip_ins', '=', 'dat.dat_id')
                  ->join('insumo.dato as dat1','insumo.insumo.ins_id_uni', '=', 'dat1.dat_id')
                  ->join('insumo.dato as dat2','insumo.insumo.ins_id_cat', '=', 'dat2.dat_id')
                  ->select('insumo.ins_id','insumo.ins_codigo','dat.dat_nom as insumo','dat1.dat_nom as unidad','dat2.dat_nom as categoria','insumo.ins_estado', 'insumo.ins_desc')
                  ->where('insumo.ins_estado', 'A')
                 // ->where('ins_usr_id', $usr)
                  //->where('ins_id_planta', $id)
                  ->get();*/
        //$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        //$id=$planta->id_planta;
        //$usr = Auth::user()->usr_id;
        $insumo = Insumo::join('insumo.tipo_insumo as tipins','insumo.insumo.ins_id_tip_ins', '=', 'tipins.tins_id')
                  ->leftjoin('insumo.unidad_medida as uni','insumo.insumo.ins_id_uni', '=', 'uni.umed_id')
                  ->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                  ->leftjoin('insumo.partida as part','insumo.insumo.ins_id_part','=','part.part_id')
                  //->join('insumo.categoria as cat','insumo.insumo.ins_id_cat', '=', 'cat.cat_id')
                  //->select('insumo.ins_id','insumo.ins_codigo','dat.dat_nom as insumo','dat1.dat_nom as unidad','dat2.dat_nom as categoria','insumo.ins_estado', 'insumo.ins_desc')
                  ->where('insumo.ins_estado', 'A')
                  //->where('tipins.tins_id','<>',3)
                 // ->where('ins_usr_id', $usr)
                  //->where('ins_id_planta', $id)
                  ->get();
        return $insumo;
    }

    protected static function getListarSinMP()
    {
        $insumo = Insumo::join('insumo.tipo_insumo as tipins','insumo.insumo.ins_id_tip_ins', '=', 'tipins.tins_id')
                  ->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')
                  ->leftjoin('insumo.partida as part','insumo.insumo.ins_id_part','=','part.part_id')
                  ->join('insumo.unidad_medida as uni','insumo.insumo.ins_id_uni', '=', 'uni.umed_id')
                //  ->join('insumo.categoria as cat','insumo.insumo.ins_id_cat', '=', 'cat.cat_id')
                  //->select('insumo.ins_id','insumo.ins_codigo','dat.dat_nom as insumo','dat1.dat_nom as unidad','dat2.dat_nom as categoria','insumo.ins_estado', 'insumo.ins_desc')
                  ->where('insumo.ins_estado', 'A')
                  ->where('tipins.tins_id','<>',3)
                 // ->where('ins_usr_id', $usr)
                  //->where('ins_id_planta', $id)
                  ->get();
        // dd($insumo);
        return $insumo;
    }

    protected static function getListarInsumo()
    {
        //$listaInsumo = Insumo::where('ins_estado','=','A')->get();
      $listaInsumo = Insumo:://join('insumo.dato as dat','insumo.insumo.ins_id_tip_ins', '=', 'dat.dat_id')
                  //->join('insumo.dato as dat1','insumo.insumo.ins_id_uni', '=', 'dat1.dat_id')
                  //->join('insumo.dato as dat2','insumo.insumo.ins_id_cat', '=', 'dat2.dat_id')
                  //->select('insumo.ins_id','insumo.ins_codigo','dat.dat_nom as insumo','dat1.dat_nom as unidad','dat2.dat_nom as categoria','insumo.ins_estado', 'insumo.ins_desc')
                  where('insumo.ins_estado', 'A')
                 // ->where('ins_usr_id', $usr)
                  //->where('ins_id_planta', $id)
                  ->get();
        return $listaInsumo;
    }

     protected static function setBuscar($id)
    {
        $insumo = Insumo::where('ins_id', $id)->first();
        return $insumo;
    }
    protected static function getDestroy($id)
    {
        $insumo = Insumo::where('ins_id', $id)->update(['ins_estado' => 'B']);
        return $insumo;
    }

    public function unidad_medida()
    {
        return $this->belongsTo('siga\Modelo\insumo\insumo_registros\UnidadMedida','ins_id_uni','umed_id');
    }
}
