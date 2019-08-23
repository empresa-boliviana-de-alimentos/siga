<?php
namespace siga\Http\Controllers\Auth;

use Illuminate\Http\Request;
use siga\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use siga\Modelo\admin\RolUsuario;
use siga\Modelo\admin\Usuario;
use Session;
use Carbon\Carbon;
use siga\Modelo\insumo\insumo_registros\Ufv;
class AuthController extends Controller
{
    public function postLogin() {
		$conect = input::only('usr_usuario', 'password');
		if (Auth::attempt($conect, true)) {
			$ids     = Auth::user()->usr_id;
			$usuario = RolUsuario::getusuarios($ids);
			$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')->where('usr_id','=',$ids)->first();
			foreach ($usuario as $row) {
				Session::put('USUARIO', $row->vusr_usuario);
				Session::put('AUTENTICADO', true);
				Session::put('ROL', $row->vusr_usuario);
				Session::put('ID_ROL', $row->vrls_id);
				Session::put('NOMBRES', $row->vprs_nombres);
				Session::put('PATERNO', $row->vprs_paterno);
				Session::put('MATERNO', $row->vprs_materno);
				Session::put('ID_USUARIO', $row->vprs_id);
				Session::put('PLANTA',$row->vprs_nombre_planta);
				Session::put('ROLUSUARIO',$row->vrls_rol);
			}
			
			return Redirect::to('/home');
		} else {
			return view('frontend.page.login');
		}
	}

public function showLoginForm() {
		$view = property_exists($this, 'loginView')
		?$this->loginView:'auth.authenticate';

		if (view()->exists($view)) {
			return view($view);
		}

		return view('frontend.page.login');
	}

	public function close() {
		Auth::logout();
		return view('frontend.index');
	}

	public function Login() {
		return view('frontend.page.login');
	}
	
	public function create(Request $data) {
		try {
			$user = Usuario::create([
					'usr_usuario' => $data['usuario'],
					'password'   => bcrypt($data['password']),
					'usr_prs_id'  => 1,
					'usr_usr_id'  => 1
				]);
			session::flash("message", "Se ha registrado el usuario ".$user->usr_usuario." de manera exitosa!");
			return view('admin.landing');
		} catch (Exception $e) {
			return view('errores.404');
		}
	}
}
