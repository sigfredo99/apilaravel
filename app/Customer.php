<?php
/*------------------------------------------------------------------------
  \file         JWTUserController
  \author       William Arturo Huillca Umpiri
  \email        Wilhuillcau@upt.pe
  \ver          0.5
  \date         30-10-2020
  \target       CU014_AutentificarUsuario
  \brief        Controlador para gestionar la autenticacion del usuario en la plataforma web
 -------------------------------------------------------------------------*/
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'cell_phone', 'password', 'status'
    ];
    

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
