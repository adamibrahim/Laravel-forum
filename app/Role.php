<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // User Roles Consts
    const ROLE_ADMIN = 1;
    const ROLE_USER  = 2;
}
