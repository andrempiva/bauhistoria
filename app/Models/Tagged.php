<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Tagged extends Pivot
{
    protected $table = "tagged";

    protected $fillable = [
        'tagged_score'
    ];

    // foreignIdFor Story::class 'story_id'
    // foreignIdFor Tag::class 'tag_id'
    // string 'my_status' default 'reading'
    // unsignedTinyInteger 'tagged_score' default 0
}
