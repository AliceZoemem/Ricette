<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('difficulty');
            $table->string('name_recipe');
            $table->string('preparation_time');
            $table->string('cooking_time');
            $table->string('doses_per_person');
            $table->string('description', 10000);
            $table->string('recipe_img');
            $table->string('category');
            //$table->string('calories');
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
        Schema::dropIfExists('recipes');
    }
}
