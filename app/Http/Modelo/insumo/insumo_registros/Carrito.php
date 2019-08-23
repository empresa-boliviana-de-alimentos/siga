<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Carrito extends Model
{
    protected $table = 'insumo.carrito';

    protected $fillable = [
        'carr_id',
        'carr_ins_id',
        'carr_prov_id',
        'carr_cantidad',
        'carr_costo',
        'carr_fecha_venc',
        'carr_usr_id',
        'carr_planta_id',
        'carr_registrado',
    ];
    protected $primaryKey = 'carr_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $usr = Auth::user()->usr_id;
        $id_planta = DB::table('public._bp_usuarios')->join('public._bp_planta as plant','public._bp_usuarios.usr_planta_id','plant.id_planta')
                        ->where('usr_id',$usr)->first();
        /*$carrsol = CarritoSolicitud::join('insumo.proveedor as prov','insumo.carro_solicitud.carr_id_prov', '=', 'prov.prov_id')
            ->join('insumo.insumo as ins','insumo.carro_solicitud.carr_id_insumo','=','ins.ins_id')
            ->join('insumo.dato as unidad','ins.ins_id_uni','=','unidad.dat_id')
            ->where('carr_estado', 'A')
            ->where('carr_usr_id', $usr)
            ->get();*/
        $carrsol = Carrito::join('insumo.proveedor as prov','insumo.carrito.carr_prov_id','=','prov.prov_id')
        				  ->join('insumo.insumo as ins','insumo.carrito.carr_ins_id','=','ins.ins_id')
        				//  ->join('insumo.unidad_medida as uni','ins.ins_id_uni','uni.umed_id')
                          ->where('carr_planta_id',$id_planta->id_planta)
        				  ->where('carr_usr_id',$usr)
        				  ->get();
        //dd($carrsol);
        return $carrsol;
    }

    protected static function getBorrarItem($id)
    {
        //$carroItem = Carrito::where('carr_id','=', $id)->update(['carr_estado' => 'B']);
        //return $carroItem;
    }
}