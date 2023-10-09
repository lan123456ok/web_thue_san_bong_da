<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'user_id',
        'campaign_title',
        'pitch_id',
        'sub_pitch_id',
        'status',
        'date',
        'start_time',
        'end_time',
    ];
    protected static function booted()
    {
        static::creating(static function ($object) {
            $object -> user_id = 3;
        });
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'campaign_title',
            ]
        ];
    }
}
