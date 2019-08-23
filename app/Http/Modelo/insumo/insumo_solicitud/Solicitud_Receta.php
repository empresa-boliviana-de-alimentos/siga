<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Solicitud_Receta extends Model
{
    protected $table = 'insumo.solcitud_receta';

    protected $fillable = [
        'solrec_id',
        'solrec_id_rec',
        'solrec_cantidad',
        'solrec_id_merc',
        'solrec_data',
        'solrec_usr_id',
        'solrec_tipo',
        'solrec_registrado',
        'solrec_modificado',
        'solrec_estado',
        'solrec_id_planta',
        'solrec_cod_nro',
        'solrec_gestion'
    ];

    protected $primaryKey = 'solrec_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $solrec = Solicitud_Receta::join('insumo.receta as rec','insumo.solcitud_receta.solrec_id_rec','=','rec.rec_id')
                    ->where('solrec_estado','=','A')->where('solrec_usr_id','=',Auth::user()->usr_id)
            ->get();
        return $solrec;
    }
}
