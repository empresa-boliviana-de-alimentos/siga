<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table      = 'acopio.departamento';

    protected $fillable   = [
        'dep_id',
        'dep_nombre',
        'dep_exp'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'dep_id';

    protected static function getListar()
    {
        $departamento = Departamento::all();
           
        return $departamento;
    }
}
