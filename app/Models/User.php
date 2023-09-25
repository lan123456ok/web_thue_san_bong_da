<?php

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'avatar',
        'password',
    ];

    public function pitch() : BelongsTo {
        return $this->belongsTo(Pitch::class);
    }

    public function getRoleNameAttribute() {
        $roleName = UserRoleEnum::getKeys($this->role)[0];
        $s = str_replace('_',' ',$roleName);
        return $s;
    }

    public function getGenderNameAttribute() {
        return ($this->gender == 0) ? 'Male' : 'Female';
    }
}
