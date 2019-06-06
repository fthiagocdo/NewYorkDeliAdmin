<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Role;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public function roles(){
        return $this->belongsToMany(Role::class);
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
