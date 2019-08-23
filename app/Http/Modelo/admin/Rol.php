<?php

namespace siga\Modelo\admin;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table      = '_bp_roles';
    protected $fillable   = ['rls_id', 'rls_rol', 'rls_registrado', 'rls_modificado', 'rls_usr_id', 'rls_estado','rls_linea_trabajo'];
    protected $primaryKey = 'rls_id';
    public $timestamps    = false;

    public function Usuario()
    {
        return HasMany('gamlp\Rol');
    }

    protected static function getListar()
    {
        $rol = Rol::where('rls_estado', 'A')->get();
        return $rol;
    }
    protected static function setBuscar($id)
    {
        $rol = Rol::where('rls_id', $id)->first();
        return $rol;
    }
    protected static function getDestroy($id)
    {
        $rol = Rol::where('rls_id', $id)->update(['rls_estado' => 'B']);
        return $rol;
    }
    protected static function getRolUser()
    {
        $id  = Auth::user()->usr_id;
        $rol = Rol::select('_bp_roles.rls_id', '_bp_roles.rls_rol')
            ->where('_bp_roles.rls_estado', 'A')

            ->whereNotIn('_bp_roles.rls_id', function ($q) use ($id) {
                $q->select('_bp_usuarios_roles.usrls_rls_id')
                    ->from('_bp_usuarios_roles')
                    ->where('_bp_usuarios_roles.usrls_usr_id',$id)
                    ->where('_bp_usuarios_roles.usrls_estado', 'A');
            })->get();
        return $rol;
    }
        protected static function getRolUserCreate($row)
    {
        $rol = Rol::select('_bp_roles.rls_id', '_bp_roles.rls_rol')
            ->where('_bp_roles.rls_estado', 'A')

            ->whereNotIn('_bp_roles.rls_id', function ($q) use ($row) {
                $q->select('_bp_usuarios_roles.usrls_rls_id')
                    ->from('_bp_usuarios_roles')
                    ->where('_bp_usuarios_roles.usrls_usr_id',$row[0])
                    ->where('_bp_usuarios_roles.usrls_estado', 'A');
            })->get();
        return $rol;
    }

    public function sel_consulta()
    {
        $rol = Rol::select('_bp_roles.rls_id', '_bp_roles.rls_rol')
                    ->where('_bp_roles.rls_estado', 'A')

                    ->whereNotIn('_bp_roles.rls_id', function ($q) use ($arr_user) {
                        $q->select('_bp_usuarios_roles.usrls_rls_id')
                            ->from('_bp_usuarios_roles')
                            ->where('_bp_usuarios_roles.usrls_usr_id', $arr_user[0])
                            ->where('_bp_usuarios_roles.usrls_estado', 'A');
                    })->get();
                    return $rol;
    }
     protected static function combo()
    {
        $rol = Rol::select('rls_id', 'rls_rol')
              ->where('rls_estado', 'A')
              ->where('rls_linea_trabajo', 1)
            ->get();
            return $rol;
    }   
}
