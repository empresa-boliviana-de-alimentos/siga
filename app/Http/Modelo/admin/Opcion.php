<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table      = '_bp_opciones';
    protected $fillable   = ['opc_id', 'opc_grp_id', 'opc_opcion', 'opc_contenido', 'opc_adicional', 'opc_orden', 'opc_imagen', 'opc_registrado', 'opc_modificado', 'opc_usr_id', 'opc_estado'];
    public $timestamps    = false;
    protected $primaryKey = 'opc_id';

    protected static function getListar()
    {
        $opcion = Opcion::join('_bp_grupos', '_bp_opciones.opc_grp_id', '=', '_bp_grupos.grp_id')->join('_bp_usuarios', '_bp_opciones.opc_usr_id', '=', '_bp_usuarios.usr_id')
            ->where('_bp_opciones.opc_estado', 'A')->get();
        return $opcion;
    }

    protected static function getDestroy($id)
    {
        $opcion = Opcion::where('opc_id', $id)->update(['opc_estado' => 'B']);
        return $opcion;
    }
    protected static function setBuscar($id)
    {
        $opcion = Opcion::where('opc_id', $id)->first();
        return $opcion;
    }

}
