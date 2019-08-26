<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use siga\Modelo\admin\RolUsuario;
use siga\Modelo\admin\Usuario;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            // The user is logged in...
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
        }
        return view('backend.template.home');
    }
}
