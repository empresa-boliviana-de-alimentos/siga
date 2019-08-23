<?php

namespace siga\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use siga\Modelo\admin\Opcion;
use siga\Modelo\admin\Grupo;
use Illuminate\Support\Facades\DB;
use siga\Modelo\admin\Usuario;

class MenuController extends Controller
{
	public function index() {

	}

	public function links($var) {
		$vb    = Auth::user()->usr_id;
		$links = Opcion::join('_bp_accesos', '_bp_opciones.opc_id', '=', '_bp_accesos.acc_opc_id')
			->join('_bp_grupos', '_bp_opciones.opc_grp_id', '=', '_bp_grupos.grp_id')
			->distinct()
			->select('_bp_opciones.opc_id', '_bp_opciones.opc_opcion', '_bp_opciones.opc_contenido', '_bp_opciones.opc_grp_id', '_bp_grupos.grp_grupo')
			->where('_bp_opciones.opc_estado', 'A')
			->whereIn('_bp_accesos.acc_rls_id', function ($q) use ($vb) {
				$q->select('_bp_usuarios_roles.usrls_rls_id')
					->from('_bp_usuarios_roles')
				->where('_bp_usuarios_roles.usrls_usr_id', $vb)
					->where('_bp_usuarios_roles.usrls_estado', 'A');
			})
			->where('_bp_opciones.opc_grp_id', $var)
			->where('_bp_accesos.acc_estado', 'A')
			->OrderBy('_bp_opciones.opc_id', 'asc')	->get();
		return $links;
	}

	public function submenus() {
		$valor1   = Auth::user()->usr_id;
		$submenus = Grupo::join('_bp_opciones', '_bp_opciones.opc_grp_id', '=', '_bp_grupos.grp_id')
			->join('_bp_accesos', '_bp_accesos.acc_opc_id', '=', '_bp_opciones.opc_id')
			->join('_bp_roles', '_bp_roles.rls_id', '=', '_bp_accesos.acc_rls_id')
			->join('_bp_usuarios_roles', '_bp_usuarios_roles.usrls_rls_id', '=', '_bp_accesos.acc_rls_id')
			->distinct()
			->select('_bp_grupos.grp_id', '_bp_grupos.grp_grupo', '_bp_grupos.grp_imagen')
			->where('grp_estado', 'A')
			->where('_bp_accesos.acc_estado', 'A')
			->where('_bp_usuarios_roles.usrls_estado', 'A')
			->where('_bp_usuarios_roles.usrls_usr_id', $valor1)
			->OrderBy('_bp_grupos.grp_id', 'asc')	->get();
		return $submenus;
	}
	public function lenguaje() {
		$sProcessing     = "Procesando Registros de la base de datos...";
		$sLengthMenu     = "Mostrar _MENU_ registros";
		$sZeroRecords    = "No se encontraron registros en la base de datos";
		$sInfo           = "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros";
		$InfoEmply       = "Mostrando registros del 0 al 0 de un total de 0 registros";
		$sInfoFiltered   = "(filtrado de un total de _MAX_ registros)";
		$sInfoPostFix    = "";
		$sSearch         = "Buscar:";
		$sUrl            = "";
		$sInfoThousands  = ",";
		$sLoadingRecords = "Cargando...";
		$sFirst          = "Primero";
		$Last            = "Ultimo";
		$Next            = "Siguiente";
		$Previous        = "Anterior";
		$sSortAscending  = "Activar para ordenar la columna de manera ascendente";
		$sSortDescending = " Activar para ordenar la columna de manera descendente";
		return response()->json(["sProcessing" => $sProcessing, "sLengthMenu" => $sLengthMenu, "sZeroRecords" => $sZeroRecords, "sInfo" => $sInfo, "InfoEmply" => $InfoEmply, "sInfoFiltered" => $sInfoFiltered, "sInfoPostFix" => $sInfoPostFix, "sSearch" => $sSearch, "sUrl" => $sUrl, "sInfoThousands" => $sInfoThousands, "sLoadingRecords" => $sLoadingRecords, "oPaginate" => ["sFirst" => $sFirst, "sLast" => $Last, "sNext" => $Next, "sPrevious" => $Previous], "oAria" => ["sSortAscending" => $sSortAscending, "sSortDescending" => $sSortDescending]]);
	}

	public function menuPlantas(){
		$id_linea = Usuario::select('usr_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
		$plantas = DB::table('_bp_planta')
				   ->where('id_linea_trabajo','=',$id_linea->usr_linea_trabajo)->get();
		// dd($plantas);
		return $plantas;
	}

	public function menuPlantasAlmendra(){
		// $id_linea = Usuario::select('usr_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
		$plantas = DB::table('_bp_planta')
				   ->where('id_linea_trabajo','=',1)->get();
		// dd($plantas);
		return $plantas;
	}

	public function menuPlantasLacteos(){
		// $id_linea = Usuario::select('usr_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
		$plantas = DB::table('_bp_planta')
				   ->where('id_linea_trabajo','=',2)->get();
		// dd($plantas);
		return $plantas;
	}

	public function menuPlantasMiel(){
		// $id_linea = Usuario::select('usr_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
		$plantas = DB::table('_bp_planta')
				   ->where('id_linea_trabajo','=',3)->get();
		// dd($plantas);
		return $plantas;
	}

	public function menuPlantasFrutos(){
		// $id_linea = Usuario::select('usr_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
		$plantas = DB::table('_bp_planta')
				   ->where('id_linea_trabajo','=',4)->get();
		// dd($plantas);
		return $plantas;
	}

	//CAMBIO DE PLANTA INSUMOS
	public function menuPlantasInsumos(){
		$id_linea = Usuario::select('usr_linea_trabajo')->where('usr_id','=',Auth::user()->usr_id)->first();
		$plantas = DB::table('_bp_planta')
					 ->where('id_linea_trabajo','=',$id_linea->usr_linea_trabajo)->get();
		return $plantas;
	}
}
