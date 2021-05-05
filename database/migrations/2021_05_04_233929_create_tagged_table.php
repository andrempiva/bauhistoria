<?php

use App\Models\Story;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagged', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Story::class);
            $table->foreignIdFor(Tag::class);
            $table->tinyInteger('tagged_score')->default(0);
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
        Schema::dropIfExists('tagged');
    }
}
