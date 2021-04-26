<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stories() {
        return $this->belongsToMany(Story::class)->withPivot([
            'status',
            'rating',
            'progress',
            'favorited',
            'shiny',
            'feels',
        ])->using(StoryUser::class);
    }

    public static function storyToListing($story) {
        if (is_array($story)) {
            // get infro from $story as an array
            return [
                'id' => $story['id'],
                'cover_path' => $story['cover_path'],
                'title' => $story['title'],
                'author' => $story['author'],
                'fandom' => $story['fandom'],
                'status' => $story['pivot']['status'],
                'rating' => $story['pivot']['rating'],
                'tags' => json_decode($story['tags']),
                'shiny' => json_decode($story['shiny']),
                'feels' => json_decode($story['feels']),
            ];
        }
        // get infro from $story as an object
        return [
            'id' => $story->id,
            'cover_path' => $story->cover_path,
            'title' => $story->title,
            'author' => $story->author,
            'fandom' => $story->fandom,
            'status' => $story->pivot->status,
            'rating' => $story->pivot->rating,
            'tags' => json_decode($story->tags),
            'shiny' => json_decode($story->shiny),
            'feels' => json_decode($story->feels),
        ];
    }

    /**
     * @return array // user listed stories info for listing
     */
    public function getStoriesForListingAttribute() {
        // return $this->stories->map('User::storytoListing');

        // should be faster?
        return array_map(__NAMESPACE__.'\User::storytoListing', $this->stories->toArray());
    }

    public function listedData($story_id) {
        $story = $this->stories()->find($story_id);
        if ($story == null) {
            return User::emptyListedData();
        }
        $data = $story->pivot->only([
            'status',
            'rating',
            'progress',
            'favorited',
            'shiny',
            'feels',
        ]);
        // $data['shiny'] = json_decode($data['shiny']);
        // $data['feels'] = json_decode($data['feels']);

        return $data;
    }

    static public function emptyListedData() {
        return [
            'status' => null,
            'rating' => null,
            'progress' => null,
            'favorited' => false,
            'shiny' => null,
            'feels' => null,
        ];
    }

    public function getStoriesForListAttribute() {
        return $this->storiesForListingAttribute();
    }

    public function getListedOf($story_id) {
        $story = $this->stories->firstWhere('id', $story_id);
        // $pivot = $this->stories()->whereId($story)->first(['status']);

        return $story == null ? 'none' : $story->pivot->status;
    }

    public function addStory($story) {
        $this->stories()->attach($story->id);
    }

    /**
     * $rating from 1 to 10 or null
     */
    public function rate(Story $story, $rating) {
        return $this->stories()->syncWithPivotValues($story->id,
            ['rating' => $rating],
            false
        );
    }

    /**
     * $favorite as one of
     *   null,
     *   true,
     *   false
     */
    public function setFavorite(Story $story, bool $favorite) {
        return $this->stories()->syncWithPivotValues($story->id,
            ['favorite' => $favorite],
            false
        );
    }

    /**
     * $listStatus as one of
     *   null,
     *   "reading",
	 *   "completed",
	 *   "on-hold",
	 *   "dropped",
	 *   "plan to read"
     */
    public function listAs(Story $story, $listStatus) {
        return $this->stories()->syncWithPivotValues($story->id,
            ['status' => $listStatus],
            false
        );
    }

    public function setProgress(Story $story, $progress) {
        return $this->stories()->syncWithPivotValues($story->id,
            ['progress' => $progress],
            false
        );
    }

    // public function setShiny(Story $story, $shiny) {
    //     $oriShiny = json_decode($story->pivot->shiny);
    //     return $this->stories()->syncWithPivotValues($story->id,
    //         ['shiny' => $shiny],
    //         false
    //     );
    // }

    public function setFeels(Story $story, $feels) {
        return $this->stories()->syncWithPivotValues($story->id,
            ['feels' => $feels],
            false
        );
    }

    // public function isListedFromListedAs($status) {
    //     $return = false;
    //     if ($status != '' && $status != null) {
    //         $return = true;
    //     }
    //     return $return;
    // }

    public function isStoryListed($story) {
        if (empty($story)) { return false; }
        if (is_array($story)) { $story = $story[0]; }

        return $story->pivot->status != 'none';
    }

    static public function isStatusListed($status) {
        if ($status == "none") { return false; }

        return true;
    }
}
