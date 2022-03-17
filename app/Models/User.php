<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Discount;

class User extends Authenticatable
{
    use Notifiable;

    public function company()
    {
        return $this->hasMany('App\Models\Company', 'company_id');
    }

    public function getEmailAttribute($value)
    {
        if (auth()->user() && (auth()->user()->isAdmin() || auth()->user()->id === $this->id))
            return decrypt($value);
        else return null;
    }

    public function getRoleAttribute($value)
    {
        return decrypt($value);
    }

    public function getNameAttribute($value)
    {
        if (auth()->user() && (auth()->user()->isAdmin() || auth()->user()->id === $this->id))
            return decrypt($value);
        else return null;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClient()
    {
        return $this->role === 'client' && $this->is_new == 0;
    }

    public function isNewClient()
    {
        return $this->role === 'client' && $this->is_new == 1;
    }
}
