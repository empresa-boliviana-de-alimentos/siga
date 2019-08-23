<?php

namespace siga\Http\Controllers\servicios;

use Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use JWTAuth;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Persona;
use siga\Modelo\admin\RolUsuario;
use siga\Modelo\admin\User;

use Tymon\JWTAuth\Exceptions\JWTException;

class ApiAuthController extends Controller {
	//ENVIO POST LOGIN GENERANDO UN TOKEN DE SESSION PARA EL USUARIO

	public function getLogin() {
		return view('auth.login');
	}
	public function postLogin(Request $request) {
		try {
			if ($token = JWTAuth::attempt(array('usr_usuario' => Input::get('usr_usuario'), 'usr_clave' => Input::get('usr_clave')))) {
				$id      = Auth::user()->usr_id;
				$usuario = RolUsuario::getusuarios($id);
				return response()->json(compact('token', 'usuario'));
			} else {
				return response()->json(['error' => 'Las credenciales son invalidas!']);
			}
		} catch (JWTException $e) {
			return response()->json(['error' => 'ups hubo un problema!']);
		}
	}

	//CERRAR SESION REFRESCANDO EL  TOKEN

	public function logout(Request $request) {
		$this->validate($request, [
				'token' => 'required'
			]);
		JWTAuth::invalidate($request->input('token'));
	}

	public function crear_usuario(Request $data) {
		$sql     = \DB::select('select * from autenticacionciudadano(?)', array($data['prs_ci']));
		$datasql = collect($sql);
		$sw      = 0;
		//return response()->json($datasql[0]->autenticacionciudadano);
		if ($datasql[0]->autenticacionciudadano == 1) {
			try {
				if ($token = JWTAuth::attempt(array('usr_usuario' => $data['usr_usuario'], 'usr_clave' => $data['usr_clave']))) {
					$id      = Auth::user()->usr_id;
					$usuario = RolUsuario::getusuarios($id);
					return response()->json($usuario);
				} else {
					echo json_encode(['error' => 'Las credenciales son invalidas!']);
				}

			} catch (JWTException $e) {
				echo json_encode(['error' => 'ups hubo un problema!']);
			}

		} elseif ($datasql[0]->autenticacionciudadano == 0) {
			try {
				$persona = Persona::create([
						'prs_id_estado_civil'    => $data['prs_id_estado_civil'],
						'prs_id_archivo_cv'      => $data['prs_id_archivo_cv'],
						'prs_nombres'            => $data['prs_nombres'],
						'prs_paterno'            => $data['prs_paterno'],
						'prs_materno'            => $data['prs_materno'],
						'prs_ci'                 => $data['prs_ci'],
						'prs_direccion'          => $data['prs_direccion'],
						'prs_telefono'           => $data['prs_telefono'],
						'prs_celular'            => $data['prs_celular'],
						'prs_empresa_telefonica' => $data['prs_empresa_telefonica'],
						'prs_correo'             => $data['prs_correo'],
						'prs_sexo'               => $data['prs_sexo'],
						'prs_fec_nacimiento'     => $data['prs_fec_nacimiento'],
						"prs_usr_id"             => 1,

					]);
				$per  = Persona::all()->last();
				$user = User::create([
						'usr_usuario'      => $data['usr_usuario'],
						'usr_clave'        => bcrypt($data['usr_clave']),
						'usr_prs_id'       => $per->prs_id,
						'usr_controlar_ip' => 'N',
						'usr_usr_id'       => $data['usuario_id'],
						'usr_cg_id'        => $data['usr_cg_id'],
					]);
				$u       = User::where('usr_oid', $data['oid'])->where('usr_estado', 'A')->first();
				$roluser = RolUsuario::create([
						'usrls_usr_id'          => $u->usr_id,
						'usrls_rls_id'          => 3,
						'usrls_usuarios_usr_id' => 1,
					]);
				return response()->json(["respuesta" => "Usuario Creado Satisfactoriamente Inicie Sesion con su cuenta"]);
			} catch (Exception $e) {
				echo json_encode(["Respuesta" => "error en el registro"]);
			}
		}
	}

	public function insert_persona(Request $data) {
		$ciu_primer_nombre = $data["ciu_primer_nombre"];
		$ciu_seg_nombre    = $data["ciu_seg_nombre"];
		$ciu_pat           = $data["ciu_pat"];
		$ciu_mat           = $data["ciu_mat"];
		$ciu_ci            = $data["ciu_ci"];
		$ciu_genero        = $data["ciu_genero"];
		$ciu_direccion     = $data["ciu_direccion"];
		$ciu_telefono      = $data["ciu_telefono"];
		$ciu_cel           = $data["ciu_cel"];
		$ciu_correo        = $data["ciu_correo"];
		$ciu_fecha_nac     = $data["ciu_fecha_nac"];
		$ciu_profesion     = $data["ciu_profesion"];
		$ciu_est_civil     = $data["ciu_est_civil"];
		$sql               = \DB::select('select * from sp_insert_ciu(?,?,?,?,?,?,?,?,?,?,?,?,?)', array($ciu_primer_nombre, $ciu_seg_nombre, $ciu_pat, $ciu_mat, $ciu_ci, $ciu_genero, $ciu_direccion, $ciu_telefono, $ciu_cel, $ciu_correo, $ciu_fecha_nac, $ciu_profesion, $ciu_est_civil));
		try {
			if (sizeof($sql) == 1) {
				return response()->json(['Respuesta' => $sql]);
			} else {
				return response()->json(['error' => 'Usted no registro ningun Vehículo']);
			}
		} catch (Exception $e) {
			return response()->json(['error' => 'intente de nuevo por favor hubo un problema'], HttpResponse::HTTP_CONFLICT);
		}
	}
}
