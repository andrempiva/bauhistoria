<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Listed extends Pivot
{
    protected $table = "listed";

    // foreignIdFor Story::class 'story_id'
    // foreignIdFor User::class 'user_id'
    // string 'my_status' default 'reading'
    // unsignedTinyInteger 'rating' nullable
    // unsignedInteger 'progress' nullable
    // boolean 'favorited' default false
}
