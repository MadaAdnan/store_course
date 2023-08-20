<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders= Order::where('user_id',\request()->get('user_id'))->get();
    return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $order=Order::create([
            'user_id'=>$request->user_id,
            'code'=>Str::random(6),
        ]);
        $carts=Cart::where('user_id',$request->user_id)->get();
        $total=0;
        foreach ($carts as $cart) {
            $total+=$cart->product->price;
          $order->items()->create([
              'product_id'=>$cart->product_id,
              'price'=>$cart->product->price,
              'count'=>$cart->count,
          ]);
          $cart->delete();
        }

        $order->update(['total'=>$total]);
        return "success";

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
        //
    }
}
