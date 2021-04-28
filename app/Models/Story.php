<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thread_title',
        'type',
        'author',
        'cover',
        // 'wss_author_link',
        'fandom',
        'status',
        'words',
        'chapters',
        'link',
        // 'link_sv',
        // 'link_ff',
        // 'link_ao3',
        // 'link_qq',
        'sequel_of',
        'prequel_of',
        'spinoff_of',
        'locked_at',
        'story_created_at',
        'story_updated_at',
    ];

    protected $dates = [
        'story_created_at',
        'story_updated_at',
    ];

    public function sequelOf() {
        return $this->hasOne(Story::class);
    }
    public function prequelOf() {
        return $this->hasOne(Story::class);
    }
    public function spinoffOf() {
        return $this->hasOne(Story::class);
    }

    public function readers() {
        // return $this->belongsToMany(User::class);
        return $this->belongsToMany(User::class)->withPivot([
            'status',
            'rating',
            'progress',
            'favorited',
            'shiny',
            'feels',
        ])->using(StoryUser::class);
    }

    public function getScoreAttribute() {
        return $this->readers()->wherePivotNull('rating')->withSum('stories','user_story.rating')->select('rating')->get();
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
