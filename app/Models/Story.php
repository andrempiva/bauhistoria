<?php

namespace App\Models;

use App\Slug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['author'];

    protected $fillable = [
        'title',
        'full_title',
        'type',
        'cover',
        'fandom',
        'story_status',
        'words',
        'chapters',
        // 'sequel_of',
        // 'prequel_of',
        // 'spinoff_of',
        'locked_at',
        'story_created_at',
        'story_updated_at',
    ];

    protected $visible = [
        'title', 'full_title', 'type', 'fandom', 'story_status', 'words',
        'chapters', 'locked_at', 'story_created_at', 'story_updated_at',
        'created_at', 'updated_at',

        'score',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'story_created_at',
        'story_updated_at',
    ];

    /**
     * Get the author that wrote the story.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Creates a new author if there's none with that name
     */
    public function setAuthorAttribute($val)
    {
        // if author wasn't changed
        if ($this->author_id && $this->author->slug === Str::slug($val)) return;
        $author = Author::firstOrCreateWithSlug($val);
        $this->author()->associate($author);
    }

    /**
     * Is a sequel, prequel or spinoff of another story?
     */
    public function sequelOf()
    {
        return $this->belongsTo(Story::class);
    }
    public function prequelOf()
    {
        return $this->belongsTo(Story::class);
    }
    public function spinoffOf()
    {
        return $this->belongsTo(Story::class);
    }
    /**
     * This story's sequel, prequel, and spinoffs
     */
    public function sequel()
    {
        return $this->hasOne(Story::class, 'sequel_of');
    }
    public function prequel()
    {
        return $this->hasOne(Story::class, 'prequel_of');
    }
    public function spinoffs()
    {
        return $this->hasMany(Story::class, 'spinoff_of');
    }

    /**
     * Get users who read the story.
     */
    public function readers()
    {
        // return $this->belongsToMany(User::class, 'listed');
        return $this->belongsToMany(User::class, 'listed')->withPivot([
            'my_status',
            'rating',
            'progress',
            'favorited',
        ])->as('listed')->withTimestamps();
    }

    /**
     * Get the tags of the story.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tagged')->withPivot([
            'tagged_score',
        ])->as('tagged')->withTimestamps();
    }

    // Generates slug from $title
    // Adds digits at the end to make the slug unique
    public function setTitleAttribute($value)
    {
        // no need to do anything if the title hasn't changed
        if ($this->title === $value) return;

        $this->attributes['title'] = $value;

        $id = $this->id ?? 0;
        $slug = Slug::createSlug($value, $id, get_class($this));

        $this->attributes['slug'] = $slug;
    }

    public function getScoreAttribute()
    {
        return Cache::remember($this->id, now()->addMinutes(10), function() {
            return $this->createScore();
        });
    }

    public function createScore()
    {
        // return $this->readers()
        //     ->withAvg('stories', 'listed.rating')->get()
        //     ->sortBy('stories_avg_listedrating')
        //     // ->get()->orderBy
        //     ;

        return $this->readers()
            // ->wherePivotNotNull('rating')
            // ->withAvg('stories', 'listed.rating')
            ->avg('rating');
    }

    public function ratedCount()
    {
        return Cache::remember($this->id.'rated-count', now()->addMinutes(10), function() {
            return $this->readers()->wherePivotNotNull('rating')->count();
        });
    }

    static public function topStories()
    {
        return Cache::remember('topStories', now()->addMinutes(10), function() {
            // return Story::withAvg('ratedReaders', 'listed.rating')->get('readers_avg_listedrating');
            return Story::withAvg('readers', 'listed.rating')->get('readers_avg_listedrating')
                ->whereNotNull('readers_avg_listedrating')
                ->sortBy('readers_avg_listedrating')
                ->take(10);
        });
    }
}
