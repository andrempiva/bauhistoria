<?php

namespace App\Models;

use Hamcrest\Type\IsArray;
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
        'trust',
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
        // return $this->belongsToMany(Story::class, 'listed');
        return $this->belongsToMany(Story::class, 'listed')->withPivot([
            'my_status',
            'rating',
            'progress',
            'favorited',
        ])->as('listed')->withTimestamps();
    }

    public static function formatStoryForListing($story) {
        if (is_array($story)) {
            // get infro from $story as an array
            return [
                'id' => $story['id'],
                'cover' => $story['cover'],
                'title' => $story['title'],
                'author' => $story['author'],
                'fandom' => $story['fandom'],
                'story_status' => $story['story_status'],
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
            'story_status' => $story->story_status,
            'my_status' => $story->listed->my_status,
            'rating' => $story->listed->rating,
        ];
    }

    /**
     * @return array // user listed stories info for listing
     */
    public function getStoriesForListingAttribute() {
        return $this->stories->map('User::formatStoryForListing');

        // should be faster?
        // return array_map(__NAMESPACE__.'\User::formatStoryForListing', $this->stories()->get(['*', 'author.name'])->toArray());
    }

    public function getStoriesForListAttribute() {
        return $this->storiesForListingAttribute();
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

    public function getListedStatusOf($story_id) {
        $story = $this->stories()->whereStoryId($story_id)->first();
        return $story ? $story->listed->my_status : $story;
        // return Listed::whereUserId($this->id)->whereStoryId($story_id)->first(['my_status'])->my_status;
        // $story = $this->stories->firstWhere('id', $story_id);

        // return $story == null ? 'none' : $story->pivot->status;
    }

    public function addStory($story, $values = []) {
        if (!is_array($values)) $values = [$values];

        $this->stories()->attach([
            $story->id => $values
        ]);
    }

    public function updateListed(Story $story, $values = []) {
        return $this->stories()
            ->updateExistingPivot($story->id, $values);
    }


    /**
     * $rating from 1 to 10 or null
     */
    public function rate(Story $story, $rating) {
        return $this->stories()
            ->updateExistingPivot($story->id, ['rating' => $rating]);
    }

    /**
     * $favorite as one of
     *   null,
     *   true,
     *   false
     */
    public function setFavorite(Story $story, bool $favorite) {
        return $this->stories()
            ->updateExistingPivot($story->id, ['favorite' => $favorite]);
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
    public function listAs(Story $story, $listedStatus) {
        return $this->stories()
            ->updateExistingPivot($story->id, ['my_status' => $listedStatus]);
    }

    public function setProgress(Story $story, $progress) {
        return $this->stories()
            ->updateExistingPivot($story->id, [
                'progress' => $story->chapters ? max([$story->chapters, $progress]) : $progress,
            ]);
    }

    public function isStoryListed($story_id) {
        return $this->stories()->whereStoryId($story_id)->exists();
    }

    public function isStoryListedAs($story_id, $status) {
        return $this->stories()->whereStoryId($story_id)->whereMyStatus($status)->exists();
    }

}
