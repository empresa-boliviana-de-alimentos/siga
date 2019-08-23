<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use Auth;

class CarritoSolicitud extends Model
{
    protected $table = 'insumo.carro_solicitud';

    protected $fillable = [
        'carr_sol_id',
        'carr_cantidad',
        'carr_costo',
        'carr_usr_id',
        'carr_estado',
        'carr_insumo',
        'carr_id_prov',
        'carr_id_insumo',
        'carr_cod_insumo',
        'carr_fech_venc'
    ];
    protected $primaryKey = 'carr_sol_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $usr = Auth::user()->usr_id;
        $carrsol = CarritoSolicitud::join('insumo.proveedor as prov','insumo.carro_solicitud.carr_id_prov', '=', 'prov.prov_id')
            ->join('insumo.insumo as ins','insumo.carro_solicitud.carr_id_insumo','=','ins.ins_id')
            ->join('insumo.dato as unidad','ins.ins_id_uni','=','unidad.dat_id')
            ->where('carr_estado', 'A')
            ->where('carr_usr_id', $usr)
            ->get();
        return $carrsol;
    }

    protected static function getBorrarItem($id)
    {
        $carroItem = CarritoSolicitud::where('carr_sol_id','=', $id)->update(['carr_estado' => 'B']);
        return $carroItem;
    }

}
