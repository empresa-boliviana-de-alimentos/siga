<?php

namespace siga\Modelo\insumo;

use Illuminate\Database\Eloquent\Model;

class Stock_Almacen_Historial extends Model
{
    protected $table = 'insumo.stock_almacen_historial';

    protected $fillable = [
        'stockalhist_id',
        'stockalhist_ins_id',
        'stockalhist_planta_id',
        'stockalhist_cantidad_dia',
        'stockalhist_cant_ingreso',
        'stockalhist_cant_salida',
        'stockalhist_fecha',
        'stockalhist_usr_id',
        'stockalhist_estado'
    ];

    protected $primaryKey = 'stockalhist_id';

    public $timestamps = false;

    // protected static function getlistar()
    // {
    //     $aprsol = Solicitud_Adicional::where('aprsol_estado','=','A')->where('aprsol_usr_id','=',Auth::user()->usr_id)
    //         ->get();
    //     return $aprsol;
    // }
}
