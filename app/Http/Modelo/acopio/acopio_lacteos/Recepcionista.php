<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

//class Persona extends Model
class Recepcionista extends Model
{
    
    protected $table      = 'acopio.resp_recep';
    protected $fillable   = ['rec_id', 'rec_nombre', 'rec_ap', 'rec_am', 'rec_ci', 'rec_tipo', 'rec_id_linea', 'rec_estado'];
    public $timestamps    = false;
    protected $primaryKey = 'rec_id';

    protected static function combo()
    {
        $data2 = Recepcionista::select('rec_id', 'rec_nombre', 'rec_ap', 'rec_am')
            ->where('rec_estado', 'A')
            ->get();
            return $data2;
    }
}
