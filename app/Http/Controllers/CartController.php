<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCartRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', \request()->get('user_id'))->get();
        return CartResource::collection($carts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCartRequest $request)
    {
        Cart::updateOrCreate([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
        ],[
            'count' => $request->count,
        ]);
        return "Success";



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::find($id)->delete();
        return "success";
    }
}
