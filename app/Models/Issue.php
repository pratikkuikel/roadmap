<?php

namespace App\Models;

use App\Events\IssueEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            event(new IssueEvent($item->id, 'Issue Created'));
        });
    }

    public function tab()
    {
        return $this->belongsTo(Tab::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'issue_tags', 'issue_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upvotes()
    {
        return $this->votes()->where('type', 'upvote')->count();
    }

    public function downvotes()
    {
        return $this->votes()->where('type', 'downvote')->count();
    }

    public function fire()
    {
        return $this->votes()->where('type', 'fire')->count();
    }
}
