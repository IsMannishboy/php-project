<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Category;
use \App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = \App\Models\Category::all();
        return response()->json([
            'cats' => $cats,
        ])->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());
        return response()->json([
            'success' => true,
            'category' => $request->name,
        ]); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cat = Category::find($id);
        if(!$cat){
            return response()->json([
                'success'=>false,
                
            ],404);
        }else{
            return response()->json([
                'category'=>$cat,
            ],200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $cat = Category::find($id);
        if(!$cat){
            return response()->json([
                'message'=>'not found',
            ],404);
        }
        $cat->update($request->validated());
        return response()->json([
            'updated'=>$cat,
        ],201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cat = Category::find($id);
        if(!$cat){
            return response()->json([
                'message'=>'not found',
            ],404);
        }
        $cat->delete();
        return response()->json([
            "message"=>"deleted",
        ],204);

    }

}
