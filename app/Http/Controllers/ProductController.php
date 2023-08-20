<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      /*Product::create([
          'name'=>$request->name,
          'price'=>$request->price,
          'info'=>$request->info,
          'status'=>$request->status,
          'user_id'=>$request->user_id,
          'category_id'=>$request->category_id,
      ]);*/
        $product=new Product();
        $product->name=$request->name;
        $product->save();
      return "Success";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ProductResource(Product::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /*Product::find($id)->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'info'=>$request->info,
            'status'=>$request->status,
            'category_id'=>$request->category_id,
        ]);*/


        return "success";

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();
        return "success";
    }
}
