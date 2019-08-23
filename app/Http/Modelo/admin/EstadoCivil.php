<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $table      = '_bp_estados_civiles';
    protected $fillable   = ['estcivil_id', 'estcivil', 'estcivil_registrado', 'estcivil_modificado', 'estcivil_usr_id', 'estcivil_estado'];
    public $timestamps    = false;
    protected $primaryKey = 'estcivil_id';
    protected static function combo()
    {
        $data = EstadoCivil::select('estcivil_id', 'estcivil')
            ->where('estcivil_estado', 'A')
            ->get();
            return $data;
    }
}
