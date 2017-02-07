<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Users extends Authenticatable
{
    use EntrustUserTrait;
    protected $table = 'users';
    protected $fillable = [
        'id',
        'firstName',
        'lastName',
        'username',
        'email',
        'password',

    ];
}

