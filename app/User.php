<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table='users';
    //manca surname
    protected $fillable = [
        'name','surname', 'email', 'password','isAdmin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function recipes()
    {
        //va in ordine alfabetico quindi prima veniva recipes_users
        return $this->belongsToMany('App\Recipe', 'users_recipes')->withPivot('recipe_id')->withTimestamps();;
    }


}
