<?php

namespace siga;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table      = '_bp_usuarios';
    // protected $fillable = ['usr_id', 'usr_usuario', 'usr_prs_id', 'usr_estado', 'password', 'usr_usr_id','usr_linea_trabajo','usr_planta_id','usr_zona_id', 'usr_id_turno'];
    protected $primaryKey = 'usr_id';
    public $timestamps    = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUfv(){
		$ids     = $this->usr_id;
		$carbon = new Carbon();
		$date = $carbon->now();
		
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
