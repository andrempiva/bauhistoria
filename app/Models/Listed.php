<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Listed extends Pivot
{
    // foreignIdFor Story::class 'story_id'
    // foreignIdFor User::class 'user_id'
    // string 'status' default 'reading'
    // unsignedTinyInteger 'rating' nullable
    // unsignedInteger 'progress' nullable
    // boolean 'favorited' default false
    // string 'shiny' nullable
    // string 'feels' nullable
}
