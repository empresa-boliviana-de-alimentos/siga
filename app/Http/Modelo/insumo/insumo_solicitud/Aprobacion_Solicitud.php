<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;
use DB;

class Aprobacion_Solicitud extends Model
{
    protected $table = 'insumo.aprobacion_solicitud';

    protected $fillable = [
        'aprsol_id',
        'aprsol_tipo_solicitud',
        'aprsol_solicitud',
        'aprsol_data',
        'aprsol_usr_id',
        'aprsol_registrado',
        'aprsol_modificado',
        'aprsol_estado',
        'aprsol_cod_solicitud',
        'aprsol_id_planta',
        'aprsol_gestion'
    ];

    protected $primaryKey = 'aprsol_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $aprsol = Solicitud_Adicional::where('aprsol_estado','=','A')->where('aprsol_usr_id','=',Auth::user()->usr_id)
            ->get();
        return $aprsol;
    }

    protected static function setBuscar($id) {
        $devolucion = \DB::table('insumo.aprobacion_solicitud')
               ->join('insumo.solicitud', 'insumo.aprobacion_solicitud.aprsol_solicitud', '=', 'sol_id')
               ->join('insumo.receta', 'solicitud.sol_id_rec', '=', 'insumo.receta.rec_id')
               ->where('aprsol_id',$id)
               ->first();
       return $devolucion;
    }
}
