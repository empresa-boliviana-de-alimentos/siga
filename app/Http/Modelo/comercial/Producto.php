<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'comercial.producto_comercial';

    protected $fillable = [
        'prod_id',
        'prod_rece_id',
        'prod_codigo',
        'prod_registrado',
        'prod_modificado',
        'prod_estado'
    ];

    protected $primaryKey = 'prod_id';

    public $timestamps = false;
}
