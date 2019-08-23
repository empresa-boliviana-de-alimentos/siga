<?php

namespace siga;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
