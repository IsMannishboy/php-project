<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

use \App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Product::all();
        return response()->json([
            "products"=>$all,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
    $name = $request->input('cat_name');

    $exists = Category::where('name', $name)->first();
        if($exists){
            $stock = Product::where('name',$request->name)->first();
            if(!$stock){
                Product::create([
                'name'=>$request->input('name'),
                'description'=>$request->description,
                'stock'=>$request->stock,
                'cat_id'=>$exists->id,
                'price'=>$request->price,
            ]);
            return response()->json([
                "status"=>"created",
            ],201);
            }
            $stock->increment('stock',$request->stock);

            return response()->json([
            "status" => "updated_stock",
            "stock"  => $stock->stock, 
            ], 200);

            
        }
        Category::create([
            'name'=>$name,
        ]);
        $cat_id = Category::where('name',$name)->value('id');
        Product::create([
                'name'=>$request->input('name'),
                'description'=>$request->input('description'),
                'stock'=>$request->stock,
                'cat_id'=>$cat_id,
                'price'=>$request->price,
            ]);
            return response()->json([
                "status"=>"created",
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                "status"=>"not found",
            ],404);
        }
        return response()->json([
            'name'=>$product->name,
            'description'=>$product->description,
            'stock'=>$product->stock,
            'price'=>$product->price,
            'cat_id'=>$product->cat_id,
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if(!$product){
            return response()->json([
                "status"=>"prod not found",
            ],404);
        }
        $cat_id = Category::where('name',$request->cat_name)->value('id');
        if(!$cat_id){
                return response()->json([
                "status"=>" cat not found",
            ],404);
        }
        $product->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'description'=>$request->description,
            'stock'=>$request->stock,
            'cat_id'=>$cat_id,
        ]);
        return response()->json([
            "status"=>"changed",
        ],204);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prod = Product::find($id);
        if(!$prod){
            return response()->json([
                "status"=>'not found'
            ],404);
        }
        $prod->delete();
        return response()->json([
            'status'=>'deleted',
        ],204);
    }
}
