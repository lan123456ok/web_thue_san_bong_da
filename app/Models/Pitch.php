<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "address",
        "address2",
        "city",
        "country",
        "cover",
        "description",
        "district",
        "name",
        "zipcode"
    ];
}
