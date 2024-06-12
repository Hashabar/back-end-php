<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function scopeUniqueName($query)
    {
        return $query->distinct('name');
    }

    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }
}
