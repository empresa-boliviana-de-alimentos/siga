<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class TipoPv extends Model
{
    protected $table = 'comercial.tipo_pv_comercial';

    protected $fillable = [
        'tipopv_id',
        'tipopv_nombre',
        'tipopv_descripcion',
        'tipopv_usr_id',
        'tipopv_registrado',
        'tipopv_modificado',
        'tipopv_estado'
    ];

    protected $primaryKey = 'tipopv_id';

    public $timestamps = false;
}
