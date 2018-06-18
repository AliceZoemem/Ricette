<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table='recipes';
    protected $fillable= ['difficulty','name_recipe','preparation_time', 'cooking_time', 'doses_per_person', 'description', 'recipe_img', 'category'];

    public function ingredients()
    {
        return $this->belongsToMany('App\Ingredient')->withPivot('ingredient_id', 'amount')->withTimestamps();;
    }

    public function ingredients_id($id = null){
        if($id != null){
            return $this->belongsToMany('App\Ingredient');
        }
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'users_recipes')->withPivot('user_id')->withTimestamps();;
    }

    public function users_id($id = null){
        if($id != null){
            return $this->belongsToMany('App\User', 'users_recipes');
        }
    }



}

