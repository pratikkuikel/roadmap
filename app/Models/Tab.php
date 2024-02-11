<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Issue;

class Tab extends Model
{
    use HasFactory;

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
