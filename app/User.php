<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'identification', 'name', 'email', 'password', 'dependencia', 'role'
    ];

//    protected $searchable = ['search'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function tickets()
    {
      return $this->hasMany(Ticket::class,'user_id');
    }
    public function traitemnts ()
    {
      return $this->hasMany(Traitement::class,'user_id');
    }

    public function categories ()
    {
        return $this->belongsToMany(Categories::class,'categories_users','user_id','categorie_id');
    }

    //public function scopeFilterTickets($query)
    //{
    //    $query->when(request()->input('priority'), function($query) {
    //        $query->whereHas('priority', function($query) {
    //            $query->whereId(request()->input('priority'));
    //        });
    //    })
    //        ->when(request()->input('category'), function($query) {
    //            $query->whereHas('category', function($query) {
    //                $query->whereId(request()->input('category'));
    //            });
    //        })
    //        ->when(request()->input('status'), function($query) {
    //            $query->whereHas('status', function($query) {
    //                $query->whereId(request()->input('status'));
    //            });
    //        });
    //}

    public function scopeByNameUser ($query)
    {
        $namem = request()->input('name');
        $role = request()->input('role');
        $query->when($namem, function($query) use ($namem) {
            $query->where('name','LIKE',"%$namem%")
                ->orWhere('identification','LIKE',"%$namem%")
                ->orWhere('email','LIKE',"%$namem%");
        })->when($role, function($query) use ($role) {
            $query->where('role',$role);
        });
        //if (trim($name) !== '' || $name !== null) return static::where('name','LIKE',"%$name%");
        //if (trim($name) !== '' || $name !== null) {
        //    $query->where('name','LIKE',"%$name%")
        //        ->orWhere('identification','LIKE',"%$name%");
        //}
    }

    public function scopeRole ($query, $role) {
        $roles = ['' => 'Seleccione un rol','user' => 'Usuario','agent' => 'Agente'];

        if (($role !== '' || $role !== null) && isset($roles[$role]))
        {
            $query->where('role', $role);
        }
    }
}
