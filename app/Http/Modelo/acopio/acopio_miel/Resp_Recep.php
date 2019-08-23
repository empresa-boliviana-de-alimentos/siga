<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Resp_Recep extends Model
{
    protected $table      = 'acopio.resp_recep';

    protected $fillable   = [
        'rec_id',
        'rec_nombre',
        'rec_ap',
        'rec_am',
        'rec_ci',
        'rec_tipo',
        'rec_id_linea',
        'rec_estado'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'rec_id';

    protected static function getListar()
    {
        $resp_recep = Resp_Recep::all();
           
        return $resp_recep;
    }
}
