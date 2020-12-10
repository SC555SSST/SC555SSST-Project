<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'username',
        'gender',
        'badge',
        'points',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        //'remember_token',
        'api_token'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    public function isAgent()
    {
        return $this->roles();
    }
    */


    public function threads(){
        return $this->hasMany('App\Models\Thread','user_id','id');
    }

    public function posts(){
        return $this->hasMany('App\Models\Post','user_id','id');
    }

    public function role(){
        return $this->belongsTo('App\Models\Role','role_id','id');
    }

}