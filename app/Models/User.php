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
        // return $this->belongsToMany(Story::class, 'listeds');
        return $this->belongsToMany(Story::class, 'listeds')->withPivot([
            'my_status',
            'rating',
            'progress',
            'favorited',
        ])->using(Listed::class)->as('listed')->withTimestamps();
    }

    public static function storyToListing($story) {
        if (is_array($story)) {
            // get infro from $story as an array
            return [
                'id' => $story['id'],
                'cover' => $story['cover'],
                'title' => $story['title'],
                'author' => $story['author'],
                'fandom' => $story['fandom'],
                'my_status' => $story['listed']['my_status'],
                'rating' => $story['listed']['rating'],
            ];
        }
        // get infro from $story as an object
        return [
            'id' => $story->id,
            'cover' => $story->cover,
            'title' => $story->title,
            'author' => $story->author,
            'fandom' => $story->fandom,
            'my_status' => $story->listed->my_status,
            'rating' => $story->listed->rating,
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
            'my_status',
            'rating',
            'progress',
            'favorited',
        ]);

        return $data;
    }

    static public function emptyListedData() {
        return [
            'my_status' => null,
            'rating' => null,
            'progress' => null,
            'favorited' => false,
        ];
    }

    public function getStoriesForListAttribute() {
        return $this->storiesForListingAttribute();
    }

    public function getListedOf($story_id) {
        $story = $this->stories->firstWhere('id', $story_id);
        // $pivot = $this->stories()->whereId($story)->first(['my_status']);

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
            ['my_status' => $listStatus],
            false
        );
    }

    public function setProgress(Story $story, $progress) {
        return $this->stories()->syncWithPivotValues($story->id,
            ['progress' => $progress],
            false
        );
    }

    public function updateListed(Story $story, $values) {
        return $this->stories()->syncWithPivotValues($story->id,
            $values,
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

    public function isStoryListed($story_id) {
        return Listed::where('story_id', $story_id)
                ->where('user_id', $this->id)->exists();
    }

    // static public function isStatusListed($status) {
    //     if ($status == "none") { return false; }

    //     return true;
    // }
}
