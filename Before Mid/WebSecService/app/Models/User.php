<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    use HasRoles; // Enables role retrieval

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // Adjust column name if needed
    }

    protected $fillable = ['name', 'email', 'role', 'password'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
