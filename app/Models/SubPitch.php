<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPitch extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable =[
        "name",
        "image",
        "type_id",
        "price_per_hour",
        "number_rentered",
        "pitch_id"
    ];
}
