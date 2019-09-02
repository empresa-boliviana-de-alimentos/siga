<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use siga\Modelo\acopio\acopio_frutos\Provincia;
use siga\Modelo\acopio\acopio_miel\Asociacion;
use siga\Modelo\acopio\acopio_miel\Comunidad;
use siga\Modelo\acopio\acopio_miel\Contrato;
use siga\Modelo\acopio\acopio_miel\Municipio;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', function () {
	return view('frontend.index');
});


// Route::post('sesion', [
// 	'as' => 'login-post',
// 	'uses' => 'Auth\AuthController@postLogin',
// ]);
// Route::get('sesion', [
// 	'as' => 'cerrar',
// 	'uses' => 'Auth\AuthController@Login',
// ]);

Route::get('test_print','ReportController@test_print');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home','HomeController@index');
	Route::get('ReportePdf', 'RerportController@prueba');
	Route::resource('Acceso', 'admin\gbAccesoController');
	Route::resource('Persona', 'admin\gbPersonaController');
	Route::resource('Usuario', 'admin\gbUsuarioController');
	Route::get('/ajax-planta', function () {
		$linea_id = Input::get('linea_id');
		$plantas = DB::table('_bp_planta')->where('id_linea_trabajo', '=', $linea_id)->get();
		return Response::json($plantas);
	});
	// CAMBIAR DE PLANTAS
	Route::get('CambioPlantas/{id}', 'admin\gbUsuarioController@updatePlanta');
	Route::get('CambioPlantasAdministrador/{id}/{id_linea}', 'admin\gbUsuarioController@updatePlantaAdmin');
	Route::resource('Rol', 'admin\gbRolController');
	Route::resource('Grupo', 'admin\gbGrupoController');
	Route::resource('Opcion', 'admin\gbOpcionController');
	Route::resource('Asignacion', 'admin\gbAsignacionController');
	Route::resource('RolUsuario', 'admin\gbRolUsuarioController');
	Route::get('lenguaje', 'MenuController@lenguaje');
	Route::get('inicio', function () {
		echo 'Bienvenido ';
		echo 'Bienvenido ' . Auth::user()->usr_usuario . ', su Id es: ' . Auth::user()->usr_id;
	});
	Route::get('close', [
		'as' => 'cerrar',
		'uses' => 'Auth\AuthController@close',
	]);
	Route::get('AsignacionRol/{id}', 'admin\gbAsignacionController@accesos');
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ACOPIO MIEL
	Route::get('AcopioMielMenu', function () {
		return view('backend.administracion.acopio.acopio_miel.index');
	});
	Route::resource('ProveedorMiel', 'acopio\acopio_miel\ProveedorMielController');
	Route::post('ProveedorMielUpdate/{id}', 'acopio\acopio_miel\ProveedorMielController@proveedorMielUpdate');
	Route::get('obtenerProveedorFA', 'acopio\acopio_miel\ProveedorMielController@obtenerProvFA');
	Route::get('obtenerProveedorProd', 'acopio\acopio_miel\ProveedorMielController@obtenerProvProd');
	Route::get('obtenerProveedorConv', 'acopio\acopio_miel\ProveedorMielController@obtenerProvConv');
	Route::resource('Municipio', 'acopio\acopio_miel\MunicipioController');
	Route::resource('AcopioMiel', 'acopio\acopio_miel\AcopioMielController');
	Route::get('RegistrarAcopioFA', 'acopio\acopio_miel\AcopioMielController@registroAcopio');
	Route::get('AcopioMielNuevo', 'acopio\acopio_miel\AcopioMielController@nuevoAcopio');
	Route::resource('AcopioMielProduccion', 'acopio\acopio_miel\AcopioMielProduccionController');
	Route::resource('AcopioMielConvenio', 'acopio\acopio_miel\AcopioMielConvenioController');
	Route::get('AcopioMielConvenio/boleta/{id}', 'acopio\acopio_miel\AcopioMielConvenioController@boleta');
	// Route::get('AcopioMielProduccion', 'acopio\acopio_miel\AcopioMielController@produccion');
	Route::get('AcopioReportes', 'acopio\acopio_miel\AcopioMielController@reportes');
	Route::get('AcopioReportesFondos', 'acopio\acopio_miel\AcopioMielController@reporteFondos');
	Route::get('AcopioReportesFondosPlantas', 'acopio\acopio_miel\AcopioMielController@reporteFondosPlantas');
	Route::get('AcopioReportesProduccion', 'acopio\acopio_miel\AcopioMielProduccionController@reporteProduccion');
	Route::get('AcopioReportesProduccionPlantas', 'acopio\acopio_miel\AcopioMielProduccionController@reporteProduccionPlantas');
	Route::get('AcopioReportesConvenio', 'acopio\acopio_miel\AcopioMielConvenioController@reporteConvenio');
	Route::get('obtenerMunicipio', 'acopio\acopio_miel\MunicipioController@obtenerMuni');
	Route::resource('Comunidad', 'acopio\acopio_miel\ComunidadController');
	Route::get('obtenerComunidad', 'acopio\acopio_miel\ComunidadController@obtenerComu');
	Route::resource('Asociacion', 'acopio\acopio_miel\AsociacionController');
	Route::get('obtenerAsociacion', 'acopio\acopio_miel\AsociacionController@obtenerAso');
	Route::resource('Destino', 'acopio\acopio_miel\DestinoController');
	Route::get('obtenerDestino', 'acopio\acopio_miel\DestinoController@obtenerDesti');
	Route::resource('RespRecep', 'acopio\acopio_miel\RespRecepController');
	Route::get('obtenerRespRecep', 'acopio\acopio_miel\RespRecepController@obtenerRespRece');
	Route::get('/ajax-proveedor', 'acopio\acopio_miel\ProveedorMielController@ajaxProveedor');
	Route::get('/ajax-calculaSaldo', 'acopio\acopio_miel\ProveedorMielController@ajaxCalculaSaldo');
	Route::get('/ajax-proveedorfaprod', 'acopio\acopio_miel\ProveedorMielController@ajaxProveedorFaProd');
	// CONTRATOS
	Route::get('listarContrato/{id}', 'acopio\acopio_miel\ProveedorMielController@listarContratos');
	Route::get('mostrarProvContra/{id}', 'acopio\acopio_miel\ProveedorMielController@mostrarProvContrato');
	Route::post('registrarContrato', 'acopio\acopio_miel\ProveedorMielController@registroContrato');
	Route::get('/ajax-contratos', function () {
		$prov_id = Input::get('prov_id');
		$contratos = Contrato::join('acopio.proveedor as prov', 'acopio.contrato.contrato_id_prov', '=', 'prov.prov_id')
			->where('contrato_id_prov', '=', $prov_id)->get();
		return Response::json($contratos);
	});
	// ENVIOS DE ACOPIO A ALMACEN
	Route::get('AcopioMielEnvioAlm', 'acopio\gbEnvioAlmacenController@listarEnvioMielAlm');
	Route::get('CreateMielEnv', 'acopio\gbEnvioAlmacenController@createEnvMiel');
	Route::post('RegistroEnvioMielAlm', 'acopio\gbEnvioAlmacenController@registroEnvioAlmMiel');
	Route::get('boletaEnvioMielAlm/{id}', 'acopio\gbEnvioAlmacenController@boletaEnvioMielAlm');
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// ACOPIO FRUTOS
	Route::get('AcopioFrutosMenu', function () {
		return view('backend.administracion.acopio.acopio_frutos.index');
	});
	Route::resource('ProveedorFrutos', 'acopio\acopio_frutos\ProveedorFrutosController');
	Route::resource('AcopioFrutos', 'acopio\acopio_frutos\AcopioFrutosController');
	Route::resource('AcopioFrutosLab', 'acopio\acopio_frutos\AcopioFrutosLabController');

	Route::resource('AcopioFrutosEnvioAlm', 'acopio\acopio_frutos\gbEnvioAlmController');

	Route::get('AcopioFrutos/lstAcopiosProvfrut/{id}', 'acopio\acopio_frutos\AcopioFrutosController@lstAcopiosProvfrut');
	Route::get('AcopioFrutosSum', 'acopio\acopio_frutos\AcopioFrutosController@sumacantfruta');
	Route::get('AcopioFrutosSumProv/{id}', 'acopio\acopio_frutos\AcopioFrutosController@sumacantfrutaProv');
	Route::get('/BoletaFruta/{id}', ['as' => 'boleta', 'uses' => 'acopio\acopio_frutos\AcopioFrutosController@boleta']);
	Route::get('AcopioFrutosLab/lstAcopiosRecfru/{id}', 'acopio\acopio_frutos\AcopioFrutosLabController@lstAcopiosRecfru');
	//Route::get('AcopioFrutosLab/1', 'acopio\acopio_frutos\AcopioFrutosLabController@editcalibre');
	Route::get('AcopioFrutosLabfru/{id}', ['as' => 'editcalibre', 'uses' => 'acopio\acopio_frutos\AcopioFrutosLabController@editcalibre']);
	Route::post('RegistroFrutos', 'acopio\acopio_frutos\AcopioFrutosController@storeFruta');
	Route::get('listarLabDetalle/{id}', 'acopio\acopio_frutos\AcopioFrutosLabController@listarLabDetalle');
	Route::get('listarDetallelab/{id}', 'acopio\acopio_frutos\AcopioFrutosLabController@lstAcopiosRecfru');

	Route::get('/ajax-provincia', function () {

		$depto_id = Input::get('depto_id');
		$provincia = Provincia::where('provi_id_dep', '=', $depto_id)->get();

		return Response::json($provincia);
	});

	//////////////////////////////////////////////////////////////////
	//ACOPIO LACTEOSBOL
	Route::get('acopio_lacteos', function () {
		return View::make('backend.administracion.acopio.acopio_lacteos.acopio_lacteos');
	});
	Route::get('regrecepleche', function () {
		return View::make('backend.administracion.acopio.acopio_lacteos.acopio.regrecepleche');
	});
	Route::resource('ProveedorL', 'acopio\acopio_lacteos\gbProveedorlacController');
	// Route::resource('AcopioLacteos', 'acopio\acopio_lacteos\gbAcopioController');
	Route::resource('ModuloLacteos', 'acopio\acopio_lacteos\gbModuloController');
	Route::get('ListarProveedoresModulo/{id}', 'acopio\acopio_lacteos\gbModuloController@listarProveedoresModulo');
	Route::get('ReporteDiarioAcopioModulos', 'acopio\acopio_lacteos\gbModuloController@reportediarioAcopioModulos');
	Route::get('listarProveedoresDell/{id}', 'acopio\acopio_lacteos\gbModuloController@listarProveedoresDell');
	Route::get('listarModuloDetalle/{id}', 'acopio\acopio_lacteos\gbRecepcionPl@listarModuloDetalle');

	Route::get('listaAcopioModulos/{id}', 'acopio\acopio_lacteos\gbAcopioControllerPl@listaAcopioModulos');

	Route::get('vistaAcopioPlDetalle/{id}', 'acopio\acopio_lacteos\gbAcopioControllerPl@vistaAcopioPlDetalle');
	Route::get('lstAcopioPlantaDetalle/{id}', 'acopio\acopio_lacteos\gbAcopioControllerPl@lstAcopioPlDetalle');

	Route::get('listaAcopioModCentro/{id}', 'acopio\acopio_lacteos\gbAcopioControllerPl@listaAcopioMod');
	Route::get('listarModuloCreate/{id}', 'acopio\acopio_lacteos\gbModuloController@listarProveedoresModulo2');

	Route::get('listarProveedorDetMes/{id}', 'acopio\acopio_lacteos\gbModuloController@listarProveedoresDetalleMes');
	Route::get('listarProveedorDetDia/{id}', 'acopio\acopio_lacteos\gbModuloController@listarProveedoresDetalleDia');
	Route::get('listarProveedorDetRango/{id}', 'acopio\acopio_lacteos\gbModuloController@listarProveedoresDetalleRango');

	Route::get('listarModDet/{id}', 'acopio\acopio_lacteos\gbRecepcionPl@listarModulosDetalle');
	Route::post('registrarProveedorMod', 'acopio\acopio_lacteos\gbModuloController@registroProveedorModulo');
	Route::get('ListarAcopioProv/{id}', 'acopio\acopio_lacteos\gbModuloController@listarAcopioProve'); //LISTAR ACOPIOS LACTEOS
	// NUEVAS RUTAS PARA REPORTES MODULO MES
	Route::get('ListarCreateAcoProv/{id}', 'acopio\acopio_lacteos\gbModuloController@listarCreateAcoProv'); //LISTAR PROVEEDORES
	// NUEVAS RUTAS PARA REPORTES MODULO DIARIO
	Route::get('ListarCreateAcoProvDia/{id}', 'acopio\acopio_lacteos\gbModuloController@listarCreateAcoProvDia'); //LISTAR ACOPIOS LACTEOS
	//NUEVAS RUTAS PARA REPORTES MODULO RANGO
	Route::get('ListarCreateAcoProvRango/{id}', 'acopio\acopio_lacteos\gbModuloController@listarCreateAcoProvRango'); //LISTAR ACOPIOS LACTEOS
	Route::get('ListarAcopiosProveedor/{id}', 'acopio\acopio_lacteos\gbModuloController@listarAcopiosProveedor'); //LISTAR ACOPIOS DE PROVEEDORES
	Route::post('RegistrarAcopioProv', 'acopio\acopio_lacteos\gbModuloController@registrarAcopioProve');

	Route::post('RegistrarAcoProv', 'acopio\acopio_lacteos\gbModuloController@registrarAcoProv'); //REGISTRAR ACOPIOS PROVEEDOR
	Route::get('ProveedorLacteos/{id}', 'acopio\acopio_lacteos\gbModuloController@getProveedorLacteos');

	Route::resource('AcopioLacteosverificar', 'acopio\acopio_lacteos\gbAcopioController@verificaenvio');

	Route::resource('AcopioLacteosEnvioAlm', 'acopio\acopio_lacteos\gbEnvioAlmController');
	Route::resource('AcopioLacteos/listar', 'acopio\acopio_lacteos\gbAcopioController');
	Route::resource('AcopioLacteosList', 'acopio\acopio_lacteos\gbAcopiolistProv');
	Route::resource('AcopioRecepcion', 'acopio\acopio_lacteos\gbRecepcionPl');

	//Route::resource('AcopioLacteosGen', 'acopio\acopio_lacteos\gbAcopioController@Registro');
	Route::resource('AcopioLacteosGen', 'acopio\acopio_lacteos\gbAcopioControllerENV');
	// Route::resource('AcopioLacteosGeneral', 'acopio\acopio_lacteos\gbAcopioController@RegistroDia');

	Route::resource('AcopioLacteosPlantas', 'acopio\acopio_lacteos\gbAcopioControllerPl');
	Route::resource('AcopioLacteosPlantas/listar', 'acopio\acopio_lacteos\gbAcopioControllerPl');
	Route::get('AcopioLacteosPlantas/lstAcopiosReclact/{id}', 'acopio\acopio_lacteos\gbAcopioControllerPl@lstAcopiosreceplact');
	// Route::resource('recepcion', 'acopio\acopio_lacteos\gbAcopioController');
	Route::get('BoletaAcopiodia', 'acopio\acopio_lacteos\gbAcopioController@boletAcopioProvL');
	Route::get('BoletaAcopiodiaConCal', 'acopio\acopio_lacteos\gbAcopioControllerPl@boletaAcopiodiaControlCalidad');
	Route::get('BoletaAcopiodiaPlanta', 'acopio\acopio_lacteos\gbAcopioController@boletAcopioProvL');
	Route::get('AcopioLacteosSum', 'acopio\acopio_lacteos\gbAcopioController@sumacantleche');
	//Route::get('AcopioLacteosSum','acopio\acopio_lacteos\gbAcopioController@sumacantleche');
	Route::post('regparametrofq', 'acopio\acopio_lacteos\gbAcopioController@crearPFQ');
	Route::post('regparametrofqAC', 'acopio\acopio_lacteos\gbAcopioController@crearPFQAC');
	Route::post('regparametropor', 'acopio\acopio_lacteos\gbAcopioController@crearPOR');
	Route::get('AcopioLacteos/lstAcopiosProvlact/{id}', 'acopio\acopio_lacteos\gbAcopioController@lstAcopiosProvlact');
	Route::get('close', [
		'as' => 'cerrar',
		'uses' => 'Auth\AuthController@close',
	]);
	Route::get('/BoletaRecepAco/{id}', ['as' => 'boleta', 'uses' => 'acopio\acopio_lacteos\gbRecepcionPl@boletAcopio']);
	Route::get('/BoletaRecepAcoDell/{id}', ['as' => 'boleta', 'uses' => 'acopio\acopio_lacteos\gbRecepcionPl@boletAcopioDetalle']);
	Route::get('AcopioLacteosLabVer/{id}', 'acopio\acopio_lacteos\gbAcopioControllerPl@editver');
	////////////////////////////////////////////////////////////////////
	//ALMENDRA
	Route::get('AcopioAlmendraMenu', function () {
		return view('backend.administracion.acopio.acopio_almendra.index');
	});
	Route::resource('Proveedor', 'acopio\acopio_almendra\gbProveedorController');
	Route::resource('Acopio', 'acopio\acopio_almendra\gbAcopioController');
	Route::resource('Acopio/listarDetalle', 'acopio\acopio_almendra\gbAcopioController');
	Route::get('/SolicitudAsol/{id}', 'acopio\acopio_almendra\gbSolicitudController@editSol');
	Route::put('/SolicitudAsol/{id}', 'acopio\acopio_almendra\gbSolicitudController@updateSol');
	Route::get('SolicitudAsoleditar/{id}', 'acopio\acopio_almendra\gbSolicitudController@editSol');

	Route::resource('SolicitudA', 'acopio\acopio_almendra\gbSolicitudController');
	Route::get('Solicitud/boleta/{id}', 'acopio\acopio_almendra\gbSolicitudController@boletaSolicitud');
	Route::get('Solicitud/boletaAsig/{id}', 'acopio\acopio_almendra\gbSolicitudController@boletaAsignacion');
	//Route::resource('../listarDetalle/{1}/Boleta','acopio\acopio_almendra\gbAcopioController@boletAcopio');
	// Route::get('Acopio/listarDetalle/{id}','acopio\acopio_almendra\gbAcopioController@listaDetalle');
	Route::get('/Boleta/{id}', ['as' => 'boletAcopio', 'uses' => 'acopio\acopio_almendra\gbAcopioController@boletAcopio']);
	Route::get('/BoletaProv/{id}', ['as' => 'boletAcopioProv', 'uses' => 'acopio\acopio_almendra\gbAcopioController@boletAcopioProv']);
	Route::get('ReportesA', 'acopio\acopio_almendra\gbAcopioController@reportes');
	Route::get('ReporteAcopio', 'acopio\acopio_almendra\gbAcopioController@reporteAcopio');
	Route::get('ReporteAcopioZona', 'acopio\acopio_almendra\gbAcopioController@reporteAcopioZona');
	Route::get('ReporteAcopioExcel', 'acopio\acopio_almendra\gbAcopioController@reporteAcopioExcel');
	Route::get('ReporteRecursos', 'acopio\acopio_almendra\gbAcopioController@reporteRecursos');
	// TRAER LOS MUNICIPIO POR DEPTARTAMENTOS
	Route::get('/ajax-municipio', function () {

		$depto_id = Input::get('depto_id');
		$municipios = Municipio::where('mun_id_dep', '=', $depto_id)->get();

		return Response::json($municipios);
	});
	Route::get('/ajax-comunidad', function () {

		$municipio_id = Input::get('municipio_id');
		$comunidades = Comunidad::where('com_id_mun', '=', $municipio_id)->get();

		return Response::json($comunidades);
	});
	Route::get('/ajax-asociacion', function () {

		$municipio_id = Input::get('municipio_id');
		$asociaciones = Asociacion::where('aso_id_mun', '=', $municipio_id)->get();

		return Response::json($asociaciones);
	});
	Route::post('RegMunicipio', 'acopio\acopio_almendra\gbProveedorController@registraMunicipio');
	Route::post('RegComunidad', 'acopio\acopio_almendra\gbProveedorController@registraComunidad');
	Route::post('RegAsociacion', 'acopio\acopio_almendra\gbProveedorController@registraAsociacion');
	// ENVIOS DE ACOPIO A ALMACEN
	Route::resource('EnvioAcopioAlm', 'acopio\gbEnvioAlmacenController');
	Route::get('boletaEnvioAlm/{id}', 'acopio\gbEnvioAlmacenController@boletaEnvioAlm');
	// DEVOLUCIONES DE DINERO
	Route::resource('DevolucionDinero', 'acopio\acopio_almendra\gbDevolucionDineroController');
	// SOLICITUDES CAMBIOS Y/O MODIFICACIONES
	Route::resource('SolicitudCambio', 'acopio\acopio_almendra\gbCambioModificacionController');
	Route::get('SolicitudCambioRealizadasCreate', 'acopio\acopio_almendra\gbCambioModificacionController@solicitudCambioRealizadasCreate');
	Route::get('obtenerAcopioAlmendra', 'acopio\acopio_almendra\gbCambioModificacionController@buscarAcopioAlmendra');
	Route::get('traerAcopioAlmendra', 'acopio\acopio_almendra\gbCambioModificacionController@datosAcopioAlmemdra');
	// SOLICITUDES RECIBIDAs
	Route::get('SolicitudRecibidaCambio', 'acopio\acopio_almendra\gbCambioModificacionController@listaSolRecibidas');
	Route::get('SolicitudRecibidaCambioCreate', 'acopio\acopio_almendra\gbCambioModificacionController@listaSolRecibidasCreate');
	Route::get('SolicitudCambioAtendidaCreate', 'acopio\acopio_almendra\gbCambioModificacionController@solicitudCambioAtendidaCreate');
	Route::get('MostrarSolicitudCambio/{id}', 'acopio\acopio_almendra\gbCambioModificacionController@mostrarSolicitudCambio');
	Route::post('AprobarSolicitudCambio', 'acopio\acopio_almendra\gbCambioModificacionController@aprobarSolicitudCambio');
	Route::delete('RechazarSolicitudCambio/{id}', 'acopio\acopio_almendra\gbCambioModificacionController@rechazarSolicitudCambio');
	Route::post('RechazarSolicitudCambio2', 'acopio\acopio_almendra\gbCambioModificacionController@rechazarSolicitudCambio2');
	// SOLICITUDES RECIBIDAS GERENTE
	Route::get('SolicitudRecibidaCambioGerente', 'acopio\acopio_almendra\gbCambioModificacionController@listaSolRecibidasGerente');
	Route::get('SolicitudRecibidaCambioGerenteCreate', 'acopio\acopio_almendra\gbCambioModificacionController@listaSolRecibidasGerenteCreate');
	// Route::get('AprobarSolicitudCambioGerente/{id}','acopio\acopio_almendra\gbCambioModificacionController@aprobarSolicitudCambioGerente');
	Route::get('RechazarSolicitudCambioGerente/{id}', 'acopio\acopio_almendra\gbCambioModificacionController@rechazarSolicitudCambioGerente');
	Route::post('AprobarSolicitudCambioGerente', 'acopio\acopio_almendra\gbCambioModificacionController@aprobarSolicitudCambioGerente');
	Route::post('RechazarSolicitudCambioGerente2', 'acopio\acopio_almendra\gbCambioModificacionController@rechazarSolicitudCambioGerente2');
	Route::get('HistoricoRecibidaCambioGerenteCreate', 'acopio\acopio_almendra\gbCambioModificacionController@historicoRecibidaCambioGerenteCreate');
	Route::get('MostrarSolicitudCambioGerente/{id}', 'acopio\acopio_almendra\gbCambioModificacionController@mostrarSolicitudCambioGerente');
	// MOSTRAR MODAL MENSAJE
	Route::get('MostrarModalSolicitudGerente/{id}', 'acopio\acopio_almendra\gbCambioModificacionController@mostrarModalSolcitudGerente');
	/////////////////////////////////////////////////////////////////////

	//***********************************************************************************************************************//
	//                                                       INSUMO                                                          //
	//***********************************************************************************************************************//
	/////////////////////////////////////////////////////////////////////
	//REGISTROS
	Route::get('InsumoRegistrosMenu', function () {
		return view('backend.administracion.insumo.insumo_registro.index');
	});
	Route::resource('ProveedorInsumo', 'insumo\insumo_registros\gbProveedorController');
	Route::resource('UfvInsumo', 'insumo\insumo_registros\gbUfvController');
	Route::resource('ServicioInsumo', 'insumo\insumo_registros\gbServiciosController');
	Route::resource('Insumo', 'insumo\insumo_registros\gbInsumoController');
	Route::resource('DatosInsumo', 'insumo\insumo_registros\gbDatosController');
	Route::get('IngresosInsumo', function () {
		return view('backend.administracion.insumo.insumo_ingresos.index');
	});
	Route::resource('IngresoAlmacen', 'insumo\insumo_registros\gbIngresoAlmacenController');
	Route::resource('IngresoPrima', 'insumo\insumo_registros\gbIngresoPrimaController');
	Route::get('IngresoTraspaso','insumo\insumo_registros\gbIngresoAlmacenController@ingresoTraspaso');
	Route::get('IngresoTraspasoCreate','insumo\insumo_registros\gbIngresoAlmacenController@ingresoTraspasoCreate');
	Route::get('verIngresoTraspaso/{id}','insumo\insumo_registros\gbIngresoAlmacenController@mostrarIngresoTraspaso');
	Route::get('GuardarIngresotraspaso','insumo\insumo_registros\gbIngresoAlmacenController@guardarIngresotraspaso');
	Route::post('EvaluacionProv', 'insumo\insumo_registros\gbProveedorController@storeEvalProv');
	Route::get('ExportarEvalucionProveedores','ReportController@reporte_proveedores');
	Route::get('ListarEvalProv/{id}', 'insumo\insumo_registros\gbProveedorController@listarEvaluaciones');

	/////**********LISTAS**************/////
	Route::get('listUnidadMedida', 'insumo\insumo_registros\gbDatosController@listUnidadMedida');
	Route::get('listPartida', 'insumo\insumo_registros\gbDatosController@listPartida');
	Route::get('listTipoIngreso', 'insumo\insumo_registros\gbDatosController@listTipoIngreso');
	Route::get('listTipoInsumo', 'insumo\insumo_registros\gbDatosController@listTipoInsumo');
	Route::get('listTipoEnvase', 'insumo\insumo_registros\gbDatosController@listTipoEnvase');
	Route::get('listMercado', 'insumo\insumo_registros\gbDatosController@listMercado');
	Route::get('listColor', 'insumo\insumo_registros\gbDatosController@listColor');
	Route::get('listSabor', 'insumo\insumo_registros\gbDatosController@listSabor');
	Route::get('listLineaProd', 'insumo\insumo_registros\gbDatosController@listLineaProd');
	Route::get('listProdEspe', 'insumo\insumo_registros\gbDatosController@listProdEspe');
	Route::get('listMunicipio', 'insumo\insumo_registros\gbDatosController@listMunicipio');
	Route::get('listSubLinea', 'insumo\insumo_registros\gbDatosController@listSubLinea');
	Route::get('listPlantaMaquila', 'insumo\insumo_registros\gbDatosController@listPlantaMaquila');

	/////**********REGISTRO***********////
	Route::post('RegUnidad', 'insumo\insumo_registros\gbDatosController@storeUni');
	Route::post('RegPartida', 'insumo\insumo_registros\gbDatosController@storePartida');
	Route::post('RegTipoIngreso', 'insumo\insumo_registros\gbDatosController@storeTipoIng');
	Route::post('RegInsumo', 'insumo\insumo_registros\gbDatosController@storeIns');
	Route::post('RegTipEnv', 'insumo\insumo_registros\gbDatosController@storeTipEnv');
	Route::post('RegMercado', 'insumo\insumo_registros\gbDatosController@storeMercado');
	Route::post('RegColor', 'insumo\insumo_registros\gbDatosController@storeColor');
	Route::post('RegSabor', 'insumo\insumo_registros\gbDatosController@storeSabor');
	Route::post('RegLineaPro', 'insumo\insumo_registros\gbDatosController@storeLinProd');
	Route::post('RegProdEsp', 'insumo\insumo_registros\gbDatosController@storeProdEsp');
	Route::post('RegMunicipio', 'insumo\insumo_registros\gbDatosController@storeMunicipio');
	Route::post('RegSubLinea', 'insumo\insumo_registros\gbDatosController@storeSubLinea');
	Route::post('RegPlantaMaquila', 'insumo\insumo_registros\gbDatosController@storePlantaMaquila');

	////************MOSTRAR********//////
	Route::get('RegUnidad/{id}', 'insumo\insumo_registros\gbDatosController@editUnidadMedida');
	Route::get('RegPartida/{id}', 'insumo\insumo_registros\gbDatosController@editPartida');
	Route::get('RegTipoIngreso/{id}', 'insumo\insumo_registros\gbDatosController@editTipoIngreso');
	Route::get('RegInsumo/{id}', 'insumo\insumo_registros\gbDatosController@editTipoInsumo');
	Route::get('RegTipEnv/{id}', 'insumo\insumo_registros\gbDatosController@editTipoEnvase');
	Route::get('RegMercado/{id}', 'insumo\insumo_registros\gbDatosController@editMercado');
	Route::get('RegColor/{id}', 'insumo\insumo_registros\gbDatosController@editColor');
	Route::get('RegSabor/{id}', 'insumo\insumo_registros\gbDatosController@editSabor');
	Route::get('RegLineaPro/{id}', 'insumo\insumo_registros\gbDatosController@editLinProd');
	Route::get('RegSubLinea/{id}', 'insumo\insumo_registros\gbDatosController@editSubLinea');
	Route::get('RegProdEsp/{id}', 'insumo\insumo_registros\gbDatosController@editProdEsp');
	Route::get('RegMunicipio/{id}', 'insumo\insumo_registros\gbDatosController@editMunicipio');
	Route::get('RegPlantaMaquila/{id}', 'insumo\insumo_registros\gbDatosController@editPlantaMaquila');

	////************MODIFICAR********//////
	Route::put('UpdateMercado/{id}', 'insumo\insumo_registros\gbDatosController@updateMercado');
	Route::put('UpdateTipoEnvase/{id}', 'insumo\insumo_registros\gbDatosController@updateTipoEnvase');
	Route::put('UpdateTipoInsumo/{id}', 'insumo\insumo_registros\gbDatosController@updateTipoInsumo');
	Route::put('UpdateTipoIngreso/{id}', 'insumo\insumo_registros\gbDatosController@updateTipoIngreso');
	Route::put('UpdateṔartida/{id}', 'insumo\insumo_registros\gbDatosController@updatePartida');
	Route::put('UpdateUnidadMed/{id}', 'insumo\insumo_registros\gbDatosController@updateUniMedida');
	Route::put('UpdateColor/{id}', 'insumo\insumo_registros\gbDatosController@updateColor');
	Route::put('UpdateSabor/{id}', 'insumo\insumo_registros\gbDatosController@updateSabor');
	Route::put('UpdateLinProd/{id}', 'insumo\insumo_registros\gbDatosController@updateLinProd');
	Route::put('UpdateSubLinea/{id}', 'insumo\insumo_registros\gbDatosController@updateSubLin');
	Route::put('UpdateProdEsp/{id}', 'insumo\insumo_registros\gbDatosController@updateProdEsp');
	Route::put('UpdateMunicipio/{id}', 'insumo\insumo_registros\gbDatosController@updateMunicipio');
	Route::put('UpdatePlantaMaquila/{id}', 'insumo\insumo_registros\gbDatosController@updatePlantaMaquila');

	////************DELETE********//////
	Route::delete('DeletMercado/{id}', 'insumo\insumo_registros\gbDatosController@destroyMercado');
	Route::delete('DeleteTipoEnvase/{id}', 'insumo\insumo_registros\gbDatosController@destroyTipoEnvase');
	Route::delete('DeleteTipoInsumo/{id}', 'insumo\insumo_registros\gbDatosController@destroyTipoInsumo');
	Route::delete('DeleteTipoIngreso/{id}', 'insumo\insumo_registros\gbDatosController@destroyTipoIngreso');
	Route::delete('DeletePartida/{id}', 'insumo\insumo_registros\gbDatosController@destroyPartida');
	Route::delete('DeleteUnidadMedida/{id}', 'insumo\insumo_registros\gbDatosController@destroyUnidadMedida');
	Route::delete('DeleteColor/{id}', 'insumo\insumo_registros\gbDatosController@destroyColor');
	Route::delete('DeleteSabor/{id}', 'insumo\insumo_registros\gbDatosController@destroySabor');
	Route::delete('DeleteLinProd/{id}', 'insumo\insumo_registros\gbDatosController@destroyLinProd');
	Route::delete('DeleteSubLinea/{id}', 'insumo\insumo_registros\gbDatosController@destroySubLinea');
	Route::delete('DeleteProdEsp/{id}', 'insumo\insumo_registros\gbDatosController@destroyProdEsp');
	Route::delete('DeleteMunicipio/{id}', 'insumo\insumo_registros\gbDatosController@destroyMunicipio');
	Route::delete('DeletePlantaMaquila/{id}', 'insumo\insumo_registros\gbDatosController@destroyPlantaMaquila');
	//  Route::resource('/Carrito', ['as'=>'listCarrito','uses'=>'insumo\insumo_registros\gbIngresoAlmacenController@listCarrito']);
	Route::get('Carrito', 'insumo\insumo_registros\gbIngresoAlmacenController@listCarrito');
	Route::get('CarritoSol', 'insumo\insumo_registros\gbIngresoAlmacenController@listCarrConf');
	Route::delete('CarritoItemDelete/{id}', 'insumo\insumo_registros\gbIngresoAlmacenController@borrarItem');
	Route::post('CarritoIngreso', 'insumo\insumo_registros\gbIngresoAlmacenController@storeIngreso');
	Route::delete('CarritoIngreso', 'insumo\insumo_registros\gbIngresoAlmacenController@borrarCarrito');
	//Route::get('/ReportPreliminar/{id}', ['as' => 'reportePreliminar', 'uses' => 'insumo\insumo_registros\gbIngresoAlmacenController@reportePreliminar']);
	Route::get('/ReportPreliminar/{id}','ReportController@ReportPreliminarIngreso');
	Route::post('Preliminar', 'insumo\insumo_registros\gbIngresoAlmacenController@storePreliminar');
	Route::delete('DeletePreliminar', 'insumo\insumo_registros\gbIngresoAlmacenController@borrarPreliminar');
	Route::get('/ReporteAlmacen/{id}', ['as' => 'reporteAlmacen', 'uses' => 'ReportController@nota_de_ingreso']);
	Route::get('ReporteUfvExcel', 'insumo\insumo_registros\gbUfvController@reporteUfvExcel');
	//Route::get('/ReportePrima/{id}', ['as' => 'reportePrima', 'uses' => 'insumo\insumo_registros\gbIngresoPrimaController@reportePrima']);
	Route::get('/ReportePrima/{id}', ['as' => 'reportePrima', 'uses' => 'ReportController@ingreso_materia_prima_pri']);
	Route::get('/ReportePrimaEnval/{id}', ['as' => 'reportePrima', 'uses' => 'ReportController@ingreso_materia_prima']);

	//RECETAS
	Route::resource('InsumoRecetas', 'insumo\insumo_recetas\gbRecetasController');
	Route::get('RegistroReceta', 'insumo\insumo_recetas\gbRecetasController@nuevaReceta');
	Route::get('RegistrarReceta', 'insumo\insumo_recetas\gbRecetasController@registrarReceta');
	Route::get('ImprimirReceta/{id}', 'ReportController@imprimir_receta');
	//Route::get('trae_uni','insumo\insumo_recetas\gbRecetasController@traeUnidad');
	Route::get('trae_uni', function () {
		$ins_id = Input::get('ins_id');
		$unidad_medida = DB::table('insumo.unidad_medida')->join('insumo.insumo as ins', 'insumo.unidad_medida.umed_id', '=', 'ins.ins_id_uni')->select('umed_nombre')->where('ins.ins_id', '=', $ins_id)->first();
		return Response::json($unidad_medida);
	});
	//SOLICITUDES
	Route::get('InsumoSolicitudesMenu', function () {
		return view('backend.administracion.insumo.insumo_solicitud.index');
	});
	Route::resource('solReceta', 'insumo\insumo_solicitudes\gbSolRecetaController');
	Route::get('getReceta', 'insumo\insumo_solicitudes\gbSolRecetaController@getReceta');
	Route::get('getDataReceta', function () {
		$rec_id = Input::get('rece_id');
		$datos = DB::table('insumo.receta')->where('rece_id', '=', $rec_id)->first();
		return Response::json($datos);
	});
	Route::get('getDataDetRecetaInsPrima', function () {
		$rec_id = Input::get('rece_id');
		$insumo_insumo = DB::table('insumo.detalle_receta')->join('insumo.insumo as ins', 'insumo.detalle_receta.detrece_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')
			->where('ins_id_tip_ins', 1)
			->where('detrece_rece_id', $rec_id)->get();
		$insumo_matprima = DB::table('insumo.detalle_receta')->join('insumo.insumo as ins', 'insumo.detalle_receta.detrece_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')
			->where('ins_id_tip_ins', 3)
			->where('detrece_rece_id', $rec_id)->get();
		foreach ($insumo_insumo as $ins) {
			$detalle_formulacion[] = array("ins_id" => $ins->ins_id, "ins_codigo" => $ins->ins_codigo, "ins_desc" => $ins->ins_desc, "umed_nombre" => $ins->umed_nombre, "detrece_cantidad" => $ins->detrece_cantidad);
		}
		foreach ($insumo_matprima as $ins) {
			$detalle_formulacion[] = array("ins_id" => $ins->ins_id, "ins_codigo" => $ins->ins_codigo, "ins_desc" => $ins->ins_desc, "umed_nombre" => $ins->umed_nombre, "detrece_cantidad" => $ins->detrece_cantidad);
		}
		return Response::json($detalle_formulacion);
	});
	Route::get('getDataDetReceta', function () {
		$rec_id = Input::get('rece_id');
		$tipo = Input::get('tipo');
        $datos_det = DB::table('insumo.detalle_receta')->join('insumo.insumo as ins', 'insumo.detalle_receta.detrece_ins_id', '=', 'ins.ins_id')->join('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')->where('detrece_rece_id', '=', $rec_id)->where('ins_id_tip_ins', $tipo)->get();
        foreach($datos_det as $dato)
        {
            $dato->cant_por=0;
        }

		return Response::json($datos_det);
	});
	// ROUTE PARA BUSCAR NOTAS DE SALIDAS
	Route::get('getNotaSal', 'insumo\insumo_solicitudes\gbSolInsumoAdController@getNotaSal');
	Route::get('getDataNotaSal', function () {
		$notasal_id = Input::get('notasal_id');
		$datos = DB::table('insumo.aprobacion_solicitud')
			->join('insumo.solicitud as sol', 'insumo.aprobacion_solicitud.aprsol_solicitud', '=', 'sol.sol_id')
			->join('insumo.receta as rec', 'sol.sol_id_rec', '=', 'rec.rec_id')
			->join('insumo.mercado as merc', 'sol.sol_id_merc', '=', 'merc.merc_id')
			->join('public._bp_usuarios as usr', 'sol.sol_usr_id', '=', 'usr.usr_id')
			->join('public._bp_personas as prs', 'usr.usr_prs_id', '=', 'prs.prs_id')
			->select('rec.rec_nombre', 'prs.prs_nombres', 'prs.prs_paterno', 'prs.prs_materno', 'merc.merc_nombre', 'aprsol_data', 'aprsol_cod_solicitud', 'aprsol_id', 'rec.rec_id', 'merc.merc_id')
			->where('aprsol_id', '=', $notasal_id)->get();
		// dd($datos);
		return Response::json($datos);
	});
	// END ROUTE BUSCAR NOTAS DE SALIDAS
	//SOLICITUDES ORP
	Route::resource('OrdenProduccion', 'insumo\insumo_solicitudes\gbOrdenProduccionController');
	Route::get('RegistroOrdenProd', 'insumo\insumo_solicitudes\gbOrdenProduccionController@viewRegistroProd');
	Route::get('getProducto', 'insumo\insumo_solicitudes\gbOrdenProduccionController@getProducto');
	Route::get('StockActualOP/{id}/{id_planta}', 'insumo\insumo_solicitudes\gbOrdenProduccionController@stock_actualOP');
	Route::get('StockActualOPMaq/{id}','insumo\insumo_solicitudes\gbOrdenProduccionController@StockActualOPMaq');
	Route::get('OrdenProduccionCreate', 'insumo\insumo_solicitudes\gbOrdenProduccionController@ordenProduccionCreate');
	Route::get('BoletaOrdenProduccion/{id}', 'ReportController@orden_de_produccion');
	Route::get('RecepcionORP', 'insumo\insumo_solicitudes\gbOrdenProduccionController@menuRecepcionORP');
	Route::get('CreateRecepcionOrp', 'insumo\insumo_solicitudes\gbOrdenProduccionController@createRecepcionOrp');
	Route::get('frmRecepORP/{id}', 'insumo\insumo_solicitudes\gbOrdenProduccionController@showFrmRecepORP');
	Route::get('ReceOrdenProduccionCreate', 'insumo\insumo_solicitudes\gbOrdenProduccionController@receOrdenProduccionCreate');
	Route::get('SolOrpReceta', 'insumo\insumo_solicitudes\gbOrdenProduccionController@menuSolOrpReceta');
	Route::get('CreateSolicitudOrp', 'insumo\insumo_solicitudes\gbOrdenProduccionController@createSolcitudOrp');
	Route::get('SoliOrdenProduccionCreate', 'insumo\insumo_solicitudes\gbOrdenProduccionController@soliOrdenProduccionCreate');
	Route::get('frmSoliORP/{id}', 'insumo\insumo_solicitudes\gbOrdenProduccionController@showFrmSoliORP');
	//SOLICITUDES POR INSUMO ADICIONAL
	Route::resource('solInsumoAd', 'insumo\insumo_solicitudes\gbSolInsumoAdController');
	Route::get('FormInsumoAdicional', 'insumo\insumo_solicitudes\gbSolInsumoAdController@formInsumoAdicional');
	Route::get('getDataOrdenProduccion', function () {
		$orprod_id = Input::get('orprod_id');
		$datos = DB::table('insumo.orden_produccion')->join('insumo.receta as rece', 'insumo.orden_produccion.orprod_rece_id', '=', 'rece.rece_id')
			->join('insumo.unidad_medida as umed', 'rece.rece_uni_id', '=', 'umed.umed_id')->join('insumo.sabor as sab', 'rece.rece_sabor_id', '=', 'sab.sab_id')->where('orprod_id', '=', $orprod_id)->first();
		return Response::json($datos);
	});
	Route::get('getDataDetOrprodInsPrima', function () {
		$det_orprod_id = Input::get('orprod_id');
		$insumo_insumo = DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins', 'insumo.detalle_orden_produccion.detorprod_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')
			->where('ins_id_tip_ins', 1)
			->where('detorprod_orprod_id', $det_orprod_id)->get();
		$insumo_matprima = DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins', 'insumo.detalle_orden_produccion.detorprod_ins_id', '=', 'ins.ins_id')
			->join('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')
			->where('ins_id_tip_ins', 3)
			->where('detorprod_orprod_id', $det_orprod_id)->get();
		foreach ($insumo_insumo as $ins) {
			$detalle_formulacion[] = array("ins_id" => $ins->ins_id, "ins_codigo" => $ins->ins_codigo, "ins_desc" => $ins->ins_desc, "umed_nombre" => $ins->umed_nombre, "detorprod_cantidad" => $ins->detorprod_cantidad);
		}
		foreach ($insumo_matprima as $ins) {
			$detalle_formulacion[] = array("ins_id" => $ins->ins_id, "ins_codigo" => $ins->ins_codigo, "ins_desc" => $ins->ins_desc, "umed_nombre" => $ins->umed_nombre, "detorprod_cantidad" => $ins->detorprod_cantidad);
		}
		return Response::json($detalle_formulacion);
	});
	Route::get('getDataDetOrprod', function () {
		$det_orprod_id = Input::get('orprod_id');
		$tipo = Input::get('tipo');
		$datos_det = DB::table('insumo.detalle_orden_produccion')->join('insumo.insumo as ins', 'insumo.detalle_orden_produccion.detorprod_ins_id', '=', 'ins.ins_id')->join('insumo.unidad_medida as uni', 'ins.ins_id_uni', '=', 'uni.umed_id')->where('detorprod_orprod_id', '=', $det_orprod_id)->where('ins_id_tip_ins', $tipo)->get();
		return Response::json($datos_det);
	});
	Route::get('SolicitudAdicionalCreate', 'insumo\insumo_solicitudes\gbSolInsumoAdController@solicitudAdicionalCreate');
	//SOLICITUDES POR TRASPASO
	Route::resource('solTraspaso', 'insumo\insumo_solicitudes\gbSolTraspasoController');
	Route::get('CarritoSolTras', 'insumo\insumo_solicitudes\gbSolTraspasoController@carritoSolTras');
	Route::get('ListarInsumosPlanta/{id}', 'insumo\insumo_solicitudes\gbSolTraspasoController@listarInsumosPlanta');
	Route::get('BoletaSolTraspaso/{id}', 'ReportController@solicitud_traspaso');
	//SOLICITUDES MAQUILA
	Route::resource('solMaquila', 'insumo\insumo_solicitudes\gbSolMaquilaController');
	Route::get('ViewFormMaquila', 'insumo\insumo_solicitudes\gbSolMaquilaController@viewFormMaquila');
	Route::get('RegistroSolMaquila', 'insumo\insumo_solicitudes\gbSolMaquilaController@registroSolMaquila');

	//SOLICITUDES RECIBIDAS DE ORP
	Route::get('FormMostrarReceta/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@formMostrarReceta');
	Route::get('AprobacionReceta', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprobacionReceta');
	Route::get('BoletaAprovReceta/{id}', 'ReportController@nota_de_salida');
	Route::resource('solRecibidas', 'insumo\insumo_solicitudes\gbSolRecibidasController');
	Route::get('FormMostrarSolAdicional/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@formMostrarSolAdicional');
	Route::get('AprobacionSolAdicional', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprobacionSolAdicional');
	Route::get('FormMostrarMaquila/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@formMostrarMaquila');
	Route::get('FormMostrarTraspaso/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@formMostrarTraspaso');
	Route::get('AprobacionTraspaso', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprobacionTraspaso');
	Route::get('AprobacionMaquila', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprobacionMaquila');

	Route::get('boletaSolReceta/{id}', 'insumo\insumo_solicitudes\gbSolRecetaController@reporteBoletaSolReceta');
	Route::get('boletaSolMaquila/{id}', 'insumo\insumo_solicitudes\gbSolTraspasoController@boletaSolMaquila');
	//Route::get('boletaSolAdicional/{id}', 'insumo\insumo_solicitudes\gbSolInsumoAdController@boletaSolAdicional');
	Route::get('boletaSolAdicional/{id}','ReportController@boleta_solicitud_adicional');
	Route::get('listMaquila', 'insumo\insumo_solicitudes\gbSolRecibidasController@listMaquila');
	Route::get('listAdicional', 'insumo\insumo_solicitudes\gbSolRecibidasController@listAdicional');
	Route::get('listTraspaso', 'insumo\insumo_solicitudes\gbSolRecibidasController@listTraspaso');

	Route::get('MostrarSolReceta/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@mostrarSoliReceta');
	Route::get('MostrarSolInsumo/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@mostrarSoliInsumos');
	Route::get('MostrarSolTrapaso/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@mostrarSoliTraspaso');
	// APROVACIONES
	Route::post('AprovacionSolReceta', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprovSolreceta');
	Route::post('AprovSolInsAdicional', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprovSolInsAdicional');
	Route::post('AprovSolTraspaso', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprovSolTraspaso');
	// BOLETAS APROBACIONES
	Route::get('BoletaAprovaReceta/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprovBoletaSolRec');
	Route::get('BoletaAprovaInsumoAdi/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprovBoletaSolInsumoAdi');
	Route::get('BoletaAprovaTraspaso/{id}', 'insumo\insumo_solicitudes\gbSolRecibidasController@aprovBoletaSolTraspaso');
	// RECHAZOS SOLICITUDES
	Route::post('RechazoSolReceta', 'insumo\insumo_solicitudes\gbSolRecibidasController@rechazoSolReceta');
	Route::post('RechazoSolInsumoAdi', 'insumo\insumo_solicitudes\gbSolRecibidasController@rechazoSolInsumoAdi');
	Route::post('RechazoSolTraspaso', 'insumo\insumo_solicitudes\gbSolRecibidasController@rechazoSolTrapaso');

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//// DEVOLUCIONES /////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('DevolucionRegistrosMenu', function () {
		return view('backend.administracion.insumo.insumo_devolucion.index');
	});
	Route::resource('DevolucionInsumo', 'insumo\insumo_devoluciones\gbDevolucionInsController');
	Route::resource('DevolucionDefectuoso', 'insumo\insumo_devoluciones\gbDevolucionDefectuosoController');
	Route::get('RegistroDevolucionDefec', 'insumo\insumo_devoluciones\gbDevolucionDefectuosoController@formDevolucionDefec');
	Route::get('RegistroDevolucionDefectuosa', 'insumo\insumo_devoluciones\gbDevolucionDefectuosoController@registroDevolucionDefectuosa');
	//Route::get('BoletaDevolucion/{id}', 'insumo\insumo_devoluciones\gbDevolucionDefectuosoController@boletaDevolucion');
	Route::get('BoletaDevolucion/{id}', 'ReportController@boleta_devolucion_defectuoso');
	Route::get('RegistroDevolucionSobrante', 'insumo\insumo_devoluciones\gbDevolucionInsController@formDevolucionSobrante');
	Route::get('RegistroDevolucionSobranteInsert', 'insumo\insumo_devoluciones\gbDevolucionInsController@registroDevolucionSobrante');
	//Route::get('BoletaDevolucionSobrante/{id}', 'insumo\insumo_devoluciones\gbDevolucionInsController@boletaDevolucionSobrante');
	Route::get('BoletaDevolucionSobrante/{id}', 'ReportController@boleta_devolucion_sobrante');
	Route::resource('DevolucionRecibida', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController');
	Route::get('DevolucionRecibidaDefecCreate', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@listarDevoDefectuosoCreate');
	Route::get('FormMostrarDevoSobrante/{id}', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@formMostrarDevoSobrante');
	Route::get('FormMostrarDevoDefectuoso/{id}', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@formMostrarDevoDefectuoso');
	Route::get('AprobacionDevolcuionSobrante', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@aprobacionDevolcuionSobrante');
	Route::get('AprobacionDevolcuionDefectuoso', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@aprobacionDevolcuionDefectuoso');
	//Route::get('BoletaAprobDevoSobrante/{id}', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@boletaAprobDevoSobrante');
	Route::get('BoletaAprobDevoSobrante/{id}','ReportController@boleta_aprobacion_sobrante');
	//Route::get('BoletaAprobDevoDefectuoso/{id}', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@boletaAprobDevoDefectuoso');
	Route::get('BoletaAprobDevoDefectuoso/{id}','ReportController@boleta_aprobacion_defectuoso');

	Route::get('DevolucionDetalle/{id}', 'insumo\insumo_devoluciones\gbDevolucionInsController@listDetalleDevolucion');
	Route::get('DevolucionDetalleRec/{id}', 'insumo\insumo_devoluciones\gbDevolucionRecibidasController@listDetalleRecibidas');

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//// REPORTES /////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('ReportesInsumoMenu', function () {
		return view('backend.administracion.insumo.insumo_reportes.index');
	});
	Route::get('ReporteAlmacenInsumo', function () {
		return view('backend.administracion.insumo.insumo_reportes.index');
	});
	Route::get('ReporteGralInsumo', function () {
		return view('backend.administracion.insumo.insumo_reportes_gral.index');
	});

	Route::resource('ListKardex', 'insumo\insumo_reportes\gbInsumoReporteController');
	Route::resource('Stock_Insumos', 'insumo\insumo_reportes\gbInsumoReporteController');

	Route::get('RptIngresoAlmacen', ['as' => 'rptIngresoAlmacen', 'uses' => 'insumo\insumo_registros\gbIngresoAlmacenController@rptIngresoAlmacen']);
	Route::get('RptIngresoGeneralInsumo', ['as' => 'rptIngresoAlmacen', 'uses' => 'insumo\insumo_registros\gbIngresoAlmacenController@rptIngresoGeneral']);
	Route::get('RpSolicitudAlmacen', ['as' => 'rptSolicitudAlmacen', 'uses' => 'insumo\insumo_solicitudes\gbSolRecetaController@rptSolicitudAlmacen']);
	Route::get('RpSolicitudGeneral', ['as' => 'rptSolicitudGeneral', 'uses' => 'insumo\insumo_solicitudes\gbSolRecetaController@rptSolicitudGeneral']);
	Route::get('RpSalidasAlmacen', ['as' => 'rptSalidasAlmacen', 'uses' => 'insumo\insumo_solicitudes\gbSolRecibidasController@rptSalidasAlmacen']);
	Route::get('RpSalidasGeneral', ['as' => 'rptSalidasGeneral', 'uses' => 'insumo\insumo_solicitudes\gbSolRecibidasController@rptSalidasGeneral']);
	Route::get('RpInventarioGeneral', ['as' => 'rptInventarioGeneral', 'uses' => 'insumo\insumo_reportes\gbInsumoReporteController@menuInventarioGeneral']);
	Route::get('ListarInventarioGeneral', ['as' => 'rptInventarioGeneral', 'uses' => 'insumo\insumo_reportes\gbInsumoReporteController@ListarInventarioGeneral']);
	// BUSQUEDA POR MES
	Route::get('RptInvMes/{mes}/{anio}', 'insumo\insumo_reportes\gbInsumoReporteController@ReporteInvMes');
	// BUSQUEDA POR DIA
	Route::get('RptInvDia/{dia}/{mes}/{anio}', 'insumo\insumo_reportes\gbInsumoReporteController@ReporteInvDia');
	// BUSQUEDA POR RANGO
	Route::get('RptInvRango/{dia_inicio}/{mes_inicio}/{anio_inicio}/{dia_fin}/{mes_fin}/{anio_fin}', 'insumo\insumo_reportes\gbInsumoReporteController@ReporteInvRango');

	Route::get('RpKardexValoradoInsumo/{id}', ['as' => 'rptKerdexInsumo', 'uses' => 'ReportController@kardex_valorado']);
	Route::get('RpKardexFisicoInsumo/{id}', 'ReportController@kardex_fisico');
	Route::get('RpMensual', ['as' => 'rptMensual', 'uses' => 'insumo\insumo_reportes\gbInsumoReporteController@rptMensual']);
	Route::get('RpMensualExcel','ReportExcelController@RpMensualExcel');
	//Route::get('RpMensual', ['as' => 'rptMensual', 'uses' => 'ReportController@RpMensual']);
	Route::get('RpCostoAlmacen', ['as' => 'rptCostoAlmacen', 'uses' => 'insumo\insumo_reportes\gbInsumoReporteController@rptCostoAlmacen']);
	Route::get('RptInventarioPlanta', 'insumo\insumo_registros\gbIngresoAlmacenController@rptInventarioPlanta');
	Route::get('StockActual/{id}', 'insumo\insumo_solicitudes\gbSolRecetaController@stock_actual');

	// LISTA  REPORTE INGRESO POR ALMACEN
	Route::get('ListaIngresoAlm', 'insumo\insumo_reportes\gbInsumoReporteController@listarIngresoAlmacen');
	Route::get('createListarIngresoAlmacen', 'insumo\insumo_reportes\gbInsumoReporteController@createListarIngresoAlmacen');
	Route::get('ReporteIngreso/{id}', 'insumo\insumo_reportes\gbInsumoReporteController@reporteIngreso');
	// LISTA REPORTE SOLICITUD POR ALMACEN
	Route::get('ListaSolicitudAlm', 'insumo\insumo_reportes\gbInsumoReporteController@listarSolicitudAlmacen');
	Route::get('ListRecetaReport', 'insumo\insumo_reportes\gbInsumoReporteController@listReceta');
	Route::get('ListMaquilaReport', 'insumo\insumo_reportes\gbInsumoReporteController@listMaquila');
	Route::get('ListAdicionalReport', 'insumo\insumo_reportes\gbInsumoReporteController@listAdicional');
	Route::get('ListTraspasoReport','insumo\insumo_reportes\gbInsumoReporteController@listTraspasoReport');
	// LITA REPORTE SALIDAS POR ALMACEN
	Route::get('ListaSalidaAlm', 'insumo\insumo_reportes\gbInsumoReporteController@listarSalidasAlmacen');
	Route::get('ListRecetaSal', 'insumo\insumo_reportes\gbInsumoReporteController@listRecetaSal');
	Route::get('ListMaquilaSal', 'insumo\insumo_reportes\gbInsumoReporteController@listMaquilaSal');
	Route::get('ListAdicionalSal', 'insumo\insumo_reportes\gbInsumoReporteController@listAdicionalSal');

	//NUEVOS
	Route::get('ListRecetaSalida','insumo\insumo_reportes\gbInsumoReporteController@listRecetaSalida');
	Route::get('ListAdicionalSalida','insumo\insumo_reportes\gbInsumoReporteController@listAdicionalSalida');
	Route::get('ListMaquilaSalida','insumo\insumo_reportes\gbInsumoReporteController@listMaquilaSalida');
	Route::get('ListTraspasoSalida','insumo\insumo_reportes\gbInsumoReporteController@listTraspasoSalida');

	//NUEVOS REPORTES GENERAL
	Route::get('ListarReporteGralIngreso','insumo\insumo_reportes\gbInsumoReporteController@listarReporteGralIngreso');
	Route::get('ListarReporteGralSolicitudes','insumo\insumo_reportes\gbInsumoReporteController@listarReporteGralSolicitudes');
	Route::get('ListarReporteGralSalidas','insumo\insumo_reportes\gbInsumoReporteController@listarReporteGralSalidas');
	Route::get('CreateListarReporteGralIngreso','insumo\insumo_reportes\gbInsumoReporteController@createListarReporteGralIngreso');
	Route::get('ListRecetaReportGral','insumo\insumo_reportes\gbInsumoReporteController@listRecetaReportGral');
	Route::get('ListAdicionalReportGral','insumo\insumo_reportes\gbInsumoReporteController@listAdicionalReportGral');
	Route::get('ListMaquilaReportGral','insumo\insumo_reportes\gbInsumoReporteController@listMaquilaReportGral');
	Route::get('ListTraspasoReportGral','insumo\insumo_reportes\gbInsumoReporteController@listTraspasoReportGral');
	Route::get('ListRecetaSalidaGral','insumo\insumo_reportes\gbInsumoReporteController@listRecetaSalidaGral');
	Route::get('ListAdicionalSalidaGral','insumo\insumo_reportes\gbInsumoReporteController@listAdicionalSalidaGral');
	Route::get('ListMaquilaSalidaGral','insumo\insumo_reportes\gbInsumoReporteController@listMaquilaSalidaGral');
	Route::get('ListTraspasoSalidaGral','insumo\insumo_reportes\gbInsumoReporteController@listTraspasoSalidaGral');
	/////////////////////////////////////////////////////////////////////////////////////////////////////////
	/// ESTADISTICAS //////////
	/// /////////////////////////////////////////////////////////////////////////////////////////////////////
	Route::get('MenuEstadistica', function () {
		return view('backend.administracion.estadistica.index');
	});
	// Route::get('EstadisticaLacteos', function(){
	//     return 'ESTADISTICAS LACTEOS';
	// });
	Route::get('EstadisticaLacteos', 'estadisticas\acopio\EstadisticaLacteosController@estadisticaDia');
	Route::get('EstadisticaAlmendra', 'estadisticas\acopio\EstadisticaAlmendraController@estadisticaDia');
	Route::get('estadisticaFechaAlmendra', 'estadisticas\acopio\EstadisticaAlmendraController@estadisticaFecha');
	Route::get('estadisticaMesAlmendra', 'estadisticas\acopio\EstadisticaAlmendraController@estadisticaMes');
	Route::get('estadisticaAnioAlmendra', 'estadisticas\acopio\EstadisticaAlmendraController@estadisticaAnio');
	Route::get('EstadisticaMiel', function () {
		return view('backend.administracion.estadistica.indexMiel');
	});
	Route::get('EstadisticaFrutos', function () {
		return 'ESTADISTICAS FRUTOS';
	});

	// ROUTES EVALUADOR
	// ROUTE REGISTRO EVALUACION
	Route::post('RegistroEvalSistema', function (Request $request) {
		DB::table('public.evaluacion_sistema')->insert([
			'evalsis_res_uno' => $request['primera_respuesta'],
			'evalsis_res_dos' => $request['segunda_respuesta'],
			'evalsis_res_tres' => $request['tercera_respuesta'],
			'evalsis_puntuacion' => $request['valoracion'],
			'evalsis_id_usuario' => \Auth::user()->usr_id,
			'evalsis_id_sistema' => 1,
			'evalsis_estado' => 'A',
		]);
		return response()->json(['Mensaje' => 'Se registro correctamente']);
	});
	// END ROUTE EVALUADOR
	Route::get('TraeUnidadInsumo/{id}', 'insumo\insumo_solicitudes\gbSolRecetaController@traeUnidadInsumo');

	//RUTAS PRODUCCION
	Route::get('MenuProduccion', function () {
		return view('backend.administracion.produccion.index');
	});
	//RUTAS PRODUCTO TERMINADO
	Route::get('MenuDato', function(){
		return view('backend.administracion.producto_terminado.datos.index');
	});
	Route::resource('Menutransportista','producto_terminado\TransportistaController');
	Route::resource('MenuCanastillos','producto_terminado\CanastilloController');
	Route::resource('MenuDestinos','producto_terminado\DestinoController');
	Route::resource('MenuIngresos','producto_terminado\IngresoProductoTerminadoController');
});


// Route::get('/home', 'HomeController@index')->name('home');
