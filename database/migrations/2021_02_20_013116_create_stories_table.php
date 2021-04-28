<?php

use App\Models\Story;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            // title
            $table->string('title')->unique();
            // full title like its shown on the forums
            $table->string('full_title')->nullable();
            // slug used for the url on the website
            $table->string('slug')->unique();
            // is it a story, quest, or adventure
            $table->string('type')->nullable();
            //author
            $table->string('author');
            // cover image
            $table->string('cover')->nullable();
            // fandom, if applicable
            $table->string('fandom')->nullable();
            // link to the story
            $table->string('link')->nullable();
            // is it complete or incomplete
            $table->string('status')->nullable();
            // word count
            $table->unsignedInteger('words')->nullable();
            // chapter count
            $table->unsignedSmallInteger('chapters')->nullable();
            // its a sequel of
            $table->foreignIdFor(Story::class, 'sequel_of')->nullable();
            // its a prequel of
            $table->foreignIdFor(Story::class, 'prequel_of')->nullable();
            // its a spínoff of
            $table->foreignIdFor(Story::class, 'spinoff_of')->nullable();
            // can be modified by users
            $table->timestamp('locked_at')->nullable();
            // when story was created
            $table->date('story_created_at')->nullable();
            // when story was last udpated
            $table->date('story_updated_at')->nullable();
            // when the database entry was created and updated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
