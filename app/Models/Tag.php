<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use hasfactory;

    private $fillable = [
        'name',
        'parent_id',
        'rating',
    ];
}
