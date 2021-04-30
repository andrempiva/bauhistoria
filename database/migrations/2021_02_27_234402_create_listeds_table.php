<?php

use App\Models\Story;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listeds', function (Blueprint $table) {
            // $table->id();
            $table->foreignIdFor(Story::class, 'story_id');
            $table->foreignIdFor(User::class, 'user_id');
            $table->string('my_status')->default('reading');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->unsignedInteger('progress')->nullable();
            $table->boolean('favorited')->default(false);
            $table->timestamps();
            $table->primary(['story_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('story_user');
    }
}
