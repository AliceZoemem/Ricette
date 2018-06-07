<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table='ingredients';
    protected $fillable= ['name'];
    //c e ne e un altro $hidden

    public function recipes()
    {
        return $this->belongsToMany('App\Recipe')->withPivot('ingredient_id', 'amount');
    }


}
