<?php

namespace siga\Http\Controllers\admin;

use Auth;
use siga\Http\Controllers\Controller;
use siga\Modelo\admin\Rol;
use siga\Modelo\admin\RolUsuario;
use siga\Modelo\admin\Usuario;
use Illuminate\Http\Request;
use Redirect;
use Session;

class gbRolUsuarioController extends Controller {
public function index()
    {
        $idrol=Session::get('ID_ROL');
        if ($idrol == 1 || $idrol == 9 || $idrol == 8 || $idrol == 22 || $idrol == 29) {
            $rolUser    = Usuario::getEstado();
            $rol        = Rol::getRolUser();
            $rolusuario = RolUsuario::getListar();
            return view('backend.administracion.admin.gbRolUsuario.index', compact('rolUser', 'rol', 'rolusuario'));
        }else{
            return redirect('/home');
        }
        
    }

    public function create()
    {
        return $rolUser = Usuario::getListar();
    }
    public function store(Request $request)
    {

        $arr_user = $request['usuario'];

        if (isset($_POST['rolnoasignado'])) {

            $arr_opc = $_POST['rolnoasignado'];

            for ($i = 0; $i < count($arr_opc); $i++) {
                RolUsuario::create([
                    'usrls_usr_id'          => $arr_user[0],
                    'usrls_rls_id'          => $arr_opc[$i],
                    'usrls_usuarios_usr_id' => Auth::user()->usr_id,
                ]);

            }Session::flash('message', 'Asignación Correcta.');

            $user = $arr_user[0];

            $rolUser = Usuario::getEstado();
            $rol        = Rol::getRolUserCreate($arr_user);
            $rolusuario = RolUsuario::getlistar1($arr_user);
            return view('backend.administracion.admin.gbRolUsuario.index', compact('rolusuario', 'rolUser', 'rol'));
            
        } else {

            if (isset($_POST['rolasignado'])) {
                $arr_acc = $_POST['rolasignado'];
                for ($i = 0; $i < count($arr_acc); $i++) {
                    RolUsuario::where('usrls_id', $arr_acc[$i])
                        ->update(['usrls_estado' => 'B']);
                }
                Session::flash('message', 'Desasignación Correcta.');
                return redirect()->route('RolUsuario.index')->with('success', 'El acceso se a eliminado correctamente');
            } else {
                Session::flash('message', 'Elija una opcion.');
                $rolUser = Usuario::getEstado();
                $rol = Rol::sel_consulta();

                $rolusuario = RolUsuario::consulta1();
                return view('backend.administracion.gbRolUsuario.index', compact('rolusuario', 'rolUser', 'rol'));
            }
        }

    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}