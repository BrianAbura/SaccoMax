<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    public function role()
    {
        return $this->belongsTo(Roles::class, 'roles_id');
    }
}
