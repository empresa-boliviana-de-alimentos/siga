<?php

namespace siga\Modelo\admin;

use DB;

use Illuminate\Database\Eloquent\Model;

use siga\Modelo\admin\RolUsuario;

class RolUsuario extends Model {
	protected $table      = '_bp_usuarios_roles';
	protected $fillable   = ['usrls_id', 'usrls_usr_id', 'usrls_rls_id', 'usrls_registrado', 'usrls_modificado', 'usrls_usuarios_usr_id', 'usrls_estado'];
	protected $primaryKey = 'usrls_id';
	public $timestamps    = false;
	protected static function getListar() {
		$rolusuario = RolUsuario::join('_bp_roles as r', 'r.rls_id', '=', '_bp_usuarios_roles.usrls_rls_id')
			->join('_bp_usuarios as u', 'u.usr_id', '=', '_bp_usuarios_roles.usrls_usr_id')
			->select('_bp_usuarios_roles.usrls_id', 'u.usr_id', 'u.usr_usuario', 'r.rls_rol', 'p.prs_id', 'p.prs_nombres', 'p.prs_paterno', 'prs_materno', 'prs_ci', 'prs_celular')
			->join('_bp_personas as p', 'u.usr_prs_id', '=', 'p.prs_id')
			->where('r.rls_estado', '<>', 'B')
			->where('u.usr_estado', '<>', 'B')
			->where('_bp_usuarios_roles.usrls_estado', '<>', 'B')
			->where('r.rls_rol', 'cobrador')
			->OrderBy('_bp_usuarios_roles.usrls_id', 'ASC')
			->get();
		$rol   = collect($rolusuario);
		$roles = $rol->unique('prs_id');
		$roles->values()->all();
		return $roles;
	}
	protected static function getListar1($row) {
		$rolusuario = RolUsuario::join('_bp_roles as r', 'r.rls_id', '=', '_bp_usuarios_roles.usrls_rls_id')
			->join('_bp_usuarios as u', 'u.usr_id', '=', '_bp_usuarios_roles.usrls_usr_id')
			->select('_bp_usuarios_roles.usrls_id', 'u.usr_usuario', 'r.rls_rol')
			->where('r.rls_estado', '<>', 'B')
			->where('u.usr_estado', '<>', 'B')
			->where('_bp_usuarios_roles.usrls_usr_id', $row[0])
			->where('_bp_usuarios_roles.usrls_estado', '<>', 'B')
			->OrderBy('_bp_usuarios_roles.usrls_id', 'ASC')
			->get();
		return $rolusuario;
	}

	public function consulta1() {
		$rolusuario = RolUsuario::join('_bp_roles as r', 'r.rls_id', '=', '_bp_usuarios_roles.usrls_rls_id', '')
			->join('_bp_usuarios as u', 'u.usr_id', '=', '_bp_usuarios_roles.usrls_usr_id')
			->select('_bp_usuarios_roles.usrls_id', 'u.usr_usuario', 'r.rls_rol')
			->where('r.rls_estado', '<>', 'B')
			->where('u.usr_estado', '<>', 'B')
			->where('_bp_usuarios_roles.usrls_usr_id', $arr_user[0])
			->where('_bp_usuarios_roles.usrls_estado', '<>', 'B')
			->OrderBy('_bp_usuarios_roles.usrls_id', 'ASC')
			->get();
		return $rolusuario;
	}

	public function getUsuario() {
		$rolusuario = RolUsuario::join('_bp_roles as r', 'r.rls_id', '=', '_bp_usuarios_roles.usrls_rls_id')
			->join('_bp_usuarios as u', 'u.usr_id', '=', '_bp_usuarios_roles.usrls_usr_id')
			->where('r.rls_estado', '<>', 'B')
			->where('u.usr_estado', '<>', 'B')
			->OrderBy('_bp_usuarios_roles.usrls_id', 'ASC')
			->get();
		return $rolusuario;
	}

	protected static function getusuarios($idusuario) {
		$gestrim = DB::select('select * from sp_obtiene_usuario(?)', array($idusuario));
		return $gestrim;
	}

}
