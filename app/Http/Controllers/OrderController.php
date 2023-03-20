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
    public function index(){
        $orders = Order::with('orderDetails.product')
        ->orderBy('created_at', 'DESC')
        ->get();
        // return response()->json($orders);
        return response(OrderResource::collection($orders));


    }
    public function getOrderUser($userId)
    {
        $orders = Order::where('id_customer', $userId)
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
    public function store($userId, Request $request)
    {
        $order = new Order;
        $order->id_customer = $userId;
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

            $product = Product::find($value['productId']);
            $product->quantity =  ($product->quantity) - $value['quantity'];
            $product->save();

        }

        Cart::where('customer_id', $userId)->delete();

        return response()->json(['success'=>'true'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($orderId)
    {
        $order = Order::where( 'id',$orderId)->with('orderDetails.product')        ->get();
        // return response()->json($order);
        return response(OrderResource::collection($order));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus($orderId, Request $request)
    {
        $order = Order::find($orderId);
        $order->status = 1;
        $order->id_employee = $request->input('id_employee');
        $order->save();
        return response()->json(['success'=>'true'], 200);

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
