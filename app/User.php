<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Business\UserBusiness;
use App\Role;
use App\Shop;
use App\Checkout;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'provider', 'provider_id', 'avatar', 'shop_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function shop(){
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function checkouts(){
        return $this->hasMany(Checkout::class, 'user_id', 'id');
    }

    public function addRole($role)
    {
        if(is_string($role)){
            return $this->roles()->save(Role::where('name', '=', $role)->firstOrFail());
        }else{
            return $this->roles()->save(Role::where('name', '=', $role->name)->firstOrFail());
        }
    }

    public function removeRole($role)
    {
        if(is_string($role)){
            return $this->roles()->detach(Role::where('name', '=', $role)->firstOrFail());
        }else{
            return $this->roles()->detach(Role::where('name', '=', $role->name)->firstOrFail());
        }
    }

    public function hasRole($role)
    {
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }else{
            return $role->intersect($this->roles)->count();
        }
    }

    public function hasAdmin()
    {
        return $this->hasRole('ADMIN');
    }
}
