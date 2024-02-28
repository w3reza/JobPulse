<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }
}
