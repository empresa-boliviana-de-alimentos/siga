<?php

namespace siga\Modelo\admin;

use Illuminate\Foundation\Auth\User as Authenticatable;
use siga\Modelo\insumo\insumo_registros\Ufv;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class User extends Authenticatable {
	// protected $fillable = array('usr_id', 'usr_prs_id', 'usr_usuario', 'password', 'usr_controlar_ip', 'usr_registrado', 'usr_modificado', 'usr_estado', 'password', 'usr_usr_id', 'usr_oid');
	// protected $hidden   = array('usr_clave');

	protected $table      = "_bp_usuarios";
	protected $primaryKey = "usr_id";
	public $timestamps    = false;
	// public static $login  = array(
	// 	'usr_clave'   => 'required',
	// 	'usr_usuario' => 'required',
	// );

	public function getAuthIdentifier() {
		return $this->getKey();
	}

	public function getAuthPassword() {
		return $this->usr_clave;
	}

	public function getReminderEmail() {
		return $this->usr_usuario;
	}

	public static function validate($data) {
		return Validator::make($data, static ::$login);
	}
	public function getUfv(){
		$ids     = Auth::user()->usr_id;
		$carbon = new Carbon();
		$date = $carbon->now();
		//dd($date);
		$day = Carbon::parse($date)->day;
		$month = Carbon::parse($date)->month;
		$year = Carbon::parse($date)->year;
	    $extracto = null;
	    $ufv = '';
		try {
		        $content = file_get_contents('https://www.bcb.gob.bo/librerias/indicadores/ufv/gestion.php?sdd=' . $day . '&smm=' . $month . '&saa=' . $year . '&Button=++Ver++&reporte_pdf=' . $month . '*' . $day . '*' . $year . '**' . $month . '*' . $day . '*' . $year . '*&edd=' . $day . '&emm=' . $month . '&eaa=' . $year . '&qlist=1');
		        $patron = '|<div align="center">(.*?)</div>|is';
	            if (preg_match_all($patron, $content, $extracto) > 0) {
	                	$ufv_exist = Ufv::where('ufv_registrado','=',$date)->first();
	                if ($ufv_exist) {
	                	//dd("SI EXISE MOSTRANDO");
	                	$ufv = $ufv_exist->ufv_cant;
	                    //Session::put('UFV', $ufv_exist->ufv_cant);
	                }else{
	                	//dd("NO EXISTE CREANDO");
	                    $new_ufv = new Ufv();
	                    $numero = trim($extracto[1][1]);
	                    $numero_dos= floatval(str_replace(',', '.', str_replace('.', '', $numero)));
	                    $new_ufv->ufv_cant = $numero_dos;
	                    //dd($numero_dos);
	                    $new_ufv->ufv_usr_id = $ids;
	                    $new_ufv->ufv_registrado = $date;
	                    $new_ufv->ufv_id_planta = 1;
	                    $new_ufv->save();
	                    $ufv = $numero_dos;
	                    //Session::put('UFV', $numero_dos);
	                }

	            } else {
	                return false;
	            }
		} catch (\Throwable $th) {
			//Session::put('UFV', 'NO UFV');
			$ufv = 'No ufv';
		}
		return $ufv;
	}
}
