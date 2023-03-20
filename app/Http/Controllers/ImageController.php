<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubImage;
use Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $subImage = new SubImage;
        // $img = $request->get('img1');
        // $imgName = time().'.' . explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
        // Image::make($request->get('img1'))->save(public_path()."/storage/uploads/products/".$imageName);
        // $subImage->image = $imgName;
        // $subImage->save();

        // $subImage = new SubImage;
        // $img = $request->get('img2');
        // $imgName = time().'.' . explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
        // Image::make($request->get('img2'))->save(public_path()."/storage/uploads/products/".$imageName);
        // $subImage->image = $imgName;
        // $subImage->save();

        // $subImage = new SubImage;
        // $img = $request->get('img3');
        // $imgName = time().'.' . explode('/', explode(':', substr($img, 0, strpos($img, ';')))[1])[1];
        // Image::make($request->get('img3'))->save(public_path()."/storage/uploads/products/".$imageName);
        // $subImage->image = $imgName;
        // $subImage->save();

        for($i=1; $i<=3; $i++) {
            $img = $request->file('img'.$i);

            // Check if an image was uploaded
            if($img) {
                // Validate the image
                if(!$img->isValid()) {
                    return response()->json(['error' => 'Invalid image'], 400);
                }
                $imgName = time().'.'.$img->getClientOriginalExtension();
                // $imageName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

                // Save the image
                Image::make($img)->save(public_path()."/storage/uploads/products/".$imgName);
                $subImage = new SubImage;
                $subImage->product_id = 6;
                $subImage->image = $imgName;
                $subImage->save();
            }
        }
        // Return success response
        return response()->json(['success' => true]);
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
