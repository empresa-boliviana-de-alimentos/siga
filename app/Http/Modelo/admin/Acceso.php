<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table      = '_bp_accesos';
    protected $fillable   = ['acc_id', 'acc_opc_id', 'acc_rls_id', 'acc_registrado', 'acc_modificado', 'acc_estado', 'acc_usr_id'];
    protected $primaryKey = 'acc_id';
    public $timestamps    = false;

    protected static function getListar($id)
    {
        $acceso = Acceso::join('_bp_opciones as o', 'o.opc_id', '=', '_bp_accesos.acc_opc_id')
            ->join('_bp_roles as r', 'r.rls_id', '=', '_bp_accesos.acc_rls_id')
            ->select('_bp_accesos.acc_id',
                '_bp_accesos.acc_opc_id',
                'o.opc_opcion',
                '_bp_accesos.acc_rls_id',
                'r.rls_rol',
                '_bp_accesos.acc_registrado',
                '_bp_accesos.acc_modificado')
            ->where('_bp_accesos.acc_estado', 'A')
            ->where('_bp_accesos.acc_rls_id', '1')
            ->OrderBy('o.opc_id', 'ASC')
            ->get();
        return $acceso;
    }

    protected static function getListarRol()
    {
        $rol_asg = Rol::where('_bp_roles.rls_estado', 'A')
            ->join('_bp_usuarios as u', 'u.usr_id', '=', '_bp_roles.rls_usr_id')->get();
        return $rol_asg;
    }


    protected static function getListarOpcion($id)
    {
        $opcion = Opcion::join('_bp_grupos as grp', 'grp.grp_id', '=', '_bp_opciones.opc_grp_id')
            ->select('grp.grp_grupo', '_bp_opciones.opc_contenido', '_bp_opciones.opc_id', '_bp_opciones.opc_usr_id',
                '_bp_opciones.opc_opcion')
            ->where('_bp_opciones.opc_estado', 'A')
            ->whereNotIn('_bp_opciones.opc_id', function ($q) {
                $q->select('_bp_accesos.acc_opc_id')
                    ->from('_bp_accesos')
                    ->where('_bp_accesos.acc_rls_id', $q)
                    ->where('_bp_accesos.acc_estado', 'A');
            })->OrderBy('_bp_opciones.opc_id', 'ASC')
            ->get();
            return $opcion;
    }

    protected static function getListarOpcionParam($vb)
    {
        $opcion = Opcion::join('_bp_grupos as grp', 'grp.grp_id', '=', '_bp_opciones.opc_grp_id')
                ->select('grp.grp_grupo', '_bp_opciones.opc_contenido', '_bp_opciones.opc_id', '_bp_opciones.opc_usr_id',
                    '_bp_opciones.opc_opcion')
                ->where('_bp_opciones.opc_estado', 'A')
                ->whereNotIn('_bp_opciones.opc_id', function ($q) use ($vb) {
                    $q->select('_bp_accesos.acc_opc_id')
                        ->from('_bp_accesos')
                        ->where('_bp_accesos.acc_rls_id', $vb)
                        ->where('_bp_accesos.acc_estado', 'A');
                })->OrderBy('_bp_opciones.opc_id', 'ASC')
                ->get();
            return $opcion;
    }

    protected static function getListarAccesoParam($vb)
    {
        $acceso = Acceso::join('_bp_opciones as o', 'o.opc_id', '=', '_bp_accesos.acc_opc_id')
                ->join('_bp_roles as r', 'r.rls_id', '=', '_bp_accesos.acc_rls_id')
                ->select('_bp_accesos.acc_id',
                    '_bp_accesos.acc_opc_id',
                    'o.opc_opcion',
                    '_bp_accesos.acc_rls_id',
                    'r.rls_rol',
                    '_bp_accesos.acc_registrado',
                    '_bp_accesos.acc_modificado')
                ->where('_bp_accesos.acc_estado', 'A')
                ->where('_bp_accesos.acc_rls_id', $vb)
                ->OrderBy('o.opc_id', 'ASC')
                ->get();
            return $acceso;
    }
}


