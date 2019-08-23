<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table      = '_bp_grupos';
    protected $fillable   = ['grp_id', 'grp_grupo', 'grp_imagen', 'grp_registrado', 'grp_modificado', 'grp_usr_id', 'grp_estado'];
    public $timestamps    = false;
    protected $primaryKey = 'grp_id';

    protected static function getListar()
    {
        $grupillo = Grupo::where('grp_estado', 'A')->get();
        return $grupillo;
    }
    protected static function getDestroy($id)
    {
        $grupo = Grupo::where('grp_id', $id)->update(['grp_estado' => 'B']);
        return $grupo;
    }
    protected static function setBuscar($id)
    {
        $grupo = Grupo::where('grp_id', $id)->first();
        return $grupo;
    }

}
