<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Image;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with(['category' => function($query) {
            $query->select('id', 'name');
        }, 'producer' => function($query) {
            $query->select('id', 'name');
        }])->orderBy('created_at', 'DESC')->get();
        return response()->json($product);


        // return response(ProductResource::collection(Product::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->image) {
            $image = $request->get('image');
            $imageName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path()."/storage/uploads/products/".$imageName);
        }

        $product = new Product;
        $product->id_category = $request['id_category'];
        $product->id_producer = $request['id_producer'];
        $product->name = $request['name'];
        $product->import_price = $request['import_price'];
        $product->price = $request['price'];
        $product->quantity = $request['quantity'];
        $product->image = $imageName;
        $product->save();
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
        $product = Product::find($id);
        return response()->json($product);
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
        $product = Product::find($id);

        $product->name = $request->name;
        $product->import_price = $request->import_price;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        if($product->image != $request->image){
            $image = $request->get('image');
            $imageName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($request->get('image'))->save(public_path()."/storage/uploads/products/".$imageName);
        } 
        else{
            $imageName = $product->image;
        }

        $product->image = $imageName;
        $product->save();
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
        $product = Product::find($id);
        if($product->image != null) {
            unlink(public_path()."/storage/uploads/products/". $product->image);
        }
        $product->delete();
        return response()->json(['success'=>'true'], 200);
    }
}
