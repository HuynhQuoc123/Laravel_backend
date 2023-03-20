<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userId)
    {
        $getCartItems = Cart::with(['product'])->where('customer_id', $userId)->get();

        // return response()->json([
        //     'getCartItems' => $getCartItems,
          
        // ]);
        return response(CartResource::collection($getCartItems));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($userId, Request $request)
    {
        
        $cart = Cart::firstOrCreate(
            ['customer_id' => $userId, 'product_id' => $request->product_id],
            ['quantity' => 0]
        );

        $cart->quantity += $request->quantity;
        $cart->save();

        return response()->json(['success'=>'true'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cartId)
    {
        $cart = Cart::find($cartId);
        $cart->delete();
        return response()->json(['success'=>'true'], 200);

    }
}
