<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'round',
        'championship_id',
        'team1',
        'team2',
        'score1',
        'score2',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function championship()
    {
        return $this->belongsTo(Championship::class);
    }
}
