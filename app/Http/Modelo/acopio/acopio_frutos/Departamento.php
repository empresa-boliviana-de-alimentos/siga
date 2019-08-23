<?php

namespace siga\Modelo\acopio\acopio_frutos;

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

     protected static function comboDep()
    {
        $data = Departamento::select('dep_id', 'dep_nombre')
        ->get();
        return $data;
    }

     protected static function comboExp()
    {
        $data = Departamento::select('dep_id', 'dep_exp')
        ->get();
        return $data;
    }
}
