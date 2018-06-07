<?php

namespace App\Http\Middleware;
use App\Recipe;
use Closure;

class Rightmenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $attributes;
    public function handle($request, Closure $next)
    {
        $vett_recipe = array();
        if(Recipe::count() <= 5){
            if(Recipe::count() == 0){
//                $create = '<p>Non ci sono ricette nel database</p>';
                $request->attributes->set('rightmenu', '<p>Non ci sono ricette nel database</p>');
                return $next($request);
            }
        }else{
            for ($i = 0; $i < 5; $i++){
                array_push($vett_recipe, Recipe::find(rand(1 , Recipe::count())));
            }
            $request->attributes->set('rightmenu', $vett_recipe);
            return $next($request);
        }
        return;
    }
}
