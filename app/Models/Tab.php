<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
