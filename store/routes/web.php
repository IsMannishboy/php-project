<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Category;
Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');
Route::get('/admin',function(){
    $products = Product::all();
    $cats = Category::all();
    $map = [];
    $cat_list = [];
    foreach($products as $p){
        $cat_name = $cats->find($p->cat_id)->name;
        $cat_list[$cat_name] = $p->cat_id;
        if( array_key_exists($cat_name,$map)){
            $map[$cat_name][] = $p;
        }else{
                    $map[$cat_name][] = $p;

        }

    }
        return Inertia::render('Admin',[
            'mapa'=>$map,
            'cat_list'=>$cat_list,
        ]);

})->name('admin');
