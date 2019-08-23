<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $table      = 'acopio.provincia';

    protected $fillable   = [
        'provi_id',
        'provi_nom',
        'provi_id_dep',
        'provi_estado',
        'provi_id_linea',     
    ];

    public $timestamps = false;

    protected $primaryKey = 'provi_id';
}
