<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderDetail;

use App\Http\Resources\OrderResource;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $orders = Order::where('id_customer', $id)
        ->with('orderDetails.product')->orderBy('created_at', 'DESC')
        ->get();

    
        //  return response()->json($orders);
        return response(OrderResource::collection($orders));
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $order = new Order;
        $order->id_customer = $id;
        $order->id_employee = $request['id_employee'];
        $order->id_contact = $request['id_contact'];
        $order->order_date = $request['order_date'];
        $order->payments = $request['payments'];
        $order->total = $request['total'];
        $order->status = $request['status'];
        $order->save();

        $carts = $request['carts'];
        foreach ($carts as $value) {
            $orderDetail = new OrderDetail;
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $value['productId']; 
            $orderDetail->quantity = $value['quantity']; 
            $orderDetail->price = $value['productPrice']; 
            $orderDetail->save();
        }

        Cart::where('customer_id', $id)->delete();

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
    public function destroy($id)
    {
        //
    }
}
