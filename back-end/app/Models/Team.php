<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $casts = [
        'name' => 'string',
    ];

    protected $fillable = ['name', 'championship_id'];

    public function championship()
    {
        return $this->belongsTo(Championship::class);
    }

    public function scopeUniqueName($query)
    {
        return $query->distinct('name');
    }

    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }
}
