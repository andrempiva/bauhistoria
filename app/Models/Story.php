<?php

namespace App\Models;

use App\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'full_title',
        'type',
        'author',
        'cover',
        'fandom',
        'story_status',
        'words',
        'chapters',
        'sequel_of',
        'prequel_of',
        'spinoff_of',
        'locked_at',
        'story_created_at',
        'story_updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'story_created_at',
        'story_updated_at',
    ];

    public function sequelOf()
    {
        return $this->hasOne(Story::class);
    }
    public function prequelOf()
    {
        return $this->hasOne(Story::class);
    }
    public function spinoffOf()
    {
        return $this->hasOne(Story::class);
    }

    public function readers()
    {
        // return $this->belongsToMany(User::class, 'listed');
        return $this->belongsToMany(User::class, 'listed')->withPivot([
            'my_status',
            'rating',
            'progress',
            'favorited',
        ])->using(Listed::class)->as('listed')->withTimestamps();
    }

    public function getScoreAttribute()
    {
        return $this->readers()->wherePivotNull('rating')->withSum('stories', 'user_story.rating')->select('rating')->get();
    }

    // Generates slug from $title
    // And adds digits at the end to make the slug unique
    public function setTitleAttribute($value)
    {
        if ($this->title === $value) return;

        $this->attributes['title'] = $value;

        $id = $this->id ?? 0;
        $slug = Slug::createSlug($value, $id, get_class($this));

        $this->attributes['slug'] = $slug;
    }
}
