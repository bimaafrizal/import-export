<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Image;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('images')->simplePaginate(10);
        //update description
        foreach ($products as $product) {
            $product->description = preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $product->description);
            $product->description = nl2br($product->description);
        }
        //update description image
        foreach ($products as $product) {
            if ($product->images->isEmpty()) {
                continue;
            }
            foreach ($product->images as $image) {
                if (empty($image->description)) {
                    continue;
                }
                $image->description = preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $image->description);
                $image->description = nl2br($image->description);
            }
            //count image
            $product->count_image = count($product->images);
        }

        // dd($products);
        return view('dashboard.views.landing-page-setting.product.index-product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x' => 'required|integer',
                'crop_y' => 'required|integer',
                'crop_width' => 'required|integer',
                'crop_height' => 'required|integer',
                'description_image1' => 'nullable|string',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x2' => 'nullable|integer',
                'crop_y2' => 'nullable|integer',
                'crop_width2' => 'nullable|integer',
                'crop_height2' => 'nullable|integer',
                'description_image2' => 'nullable|string',
                'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x3' => 'nullable|integer',
                'crop_y3' => 'nullable|integer',
                'crop_width3' => 'nullable|integer',
                'crop_height3' => 'nullable|integer',
                'description_image3' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //save product
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'landing_page_id' => 1,
            ]);

            //save image
            $imageId = [];
            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $imageId[] = $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), null, 'product', $request->description_image1);
                }
            }

            if ($request->hasFile('image2')) {
                if (isset($request->crop_x2) && isset($request->crop_y2) && isset($request->crop_width2) && isset($request->crop_height2)) {
                    $imageId[] = $this->saveUploadImage($request->crop_x2, $request->crop_y2, $request->crop_width2, $request->crop_height2, $request->file('image2'), null, 'product', $request->description_image2);
                }
            }

            if ($request->hasFile('image3')) {
                if (isset($request->crop_x3) && isset($request->crop_y3) && isset($request->crop_width3) && isset($request->crop_height3)) {
                    $imageId[] = $this->saveUploadImage($request->crop_x3, $request->crop_y3, $request->crop_width3, $request->crop_height3, $request->file('image3'), null, 'product', $request->description_image3);
                }
            }

            //save product image
            foreach ($imageId as $id) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_id' => $id,
                ]);
            }

            return redirect()->back()->with('success', 'Add product success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $product = Product::with('images')->find($id);
            if (!$product) {
                throw new \Exception('Product not found');
            }
            $images = null;
            if (!$product->images->isEmpty()) {
                $images = $product->images;
                foreach ($images as $image) {
                    if (empty($image->description)) {
                        continue;
                    }
                    $image->description = preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $image->description);
                    $image->description = nl2br($image->description);
                }
            }

            return view('dashboard.views.landing-page-setting.product.edit-product', compact('product', 'images'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'description' => 'required|string',
                'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x1' => 'nullable|integer',
                'crop_y1' => 'nullable|integer',
                'crop_width1' => 'nullable|integer',
                'crop_height1' => 'nullable|integer',
                'description_image1' => 'nullable|string',
                'statusEdited1' => 'nullable|string',
                'descriptionEdited1' => 'nullable|string',
                'imageId1' => 'nullable|integer',
                'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x2' => 'nullable|integer',
                'crop_y2' => 'nullable|integer',
                'crop_width2' => 'nullable|integer',
                'crop_height2' => 'nullable|integer',
                'description_image2' => 'nullable|string',
                'statusEdited2' => 'nullable|string',
                'descriptionEdited2' => 'nullable|string',
                'imageId2' => 'nullable|integer',
                'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50048',
                'crop_x3' => 'nullable|integer',
                'crop_y3' => 'nullable|integer',
                'crop_width3' => 'nullable|integer',
                'crop_height3' => 'nullable|integer',
                'description_image3' => 'nullable|string',
                'statusEdited3' => 'nullable|string',
                'imageId3' => 'nullable|integer',
                'descriptionEdited3' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            //add validation minimun has one image
            if ((!$request->hasFile('image1') && !$request->hasFile('image2') && !$request->hasFile('image3')) && (($request->statusEdited1 == 'no-isset' || $request->statusEdited1 == 'deleted') && ($request->statusEdited2 == 'no-isset' || $request->statusEdited2 == 'deleted') && ($request->statusEdited3 == 'no-isset' || $request->statusEdited3 == 'deleted'))) {
                return redirect()->back()->with('error', 'Please upload at least one image');
            }

            $id = decrypt($id);
            $product = Product::find($id);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            //update product
            Product::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            //update image / description
            if ($request->hasFile('image1') && $request->statusEdited1 == 'edited') {
                if (isset($request->crop_x1) && isset($request->crop_y1) && isset($request->crop_width1) && isset($request->crop_height1)) {
                    $this->saveUploadImage($request->crop_x1, $request->crop_y1, $request->crop_width1, $request->crop_height1, $request->file('image1'), $request->imageId1, 'product', $request->description_image1, ['type' => 'product', 'product_id' => $id]);
                }
            } else if ($request->descriptionEdited1 == 'edited') {
                $this->updateDescription($request->imageId1, $request->description_image1);
            } else if ($request->statusEdited1 == 'deleted') {
                $this->deleteImage($request->imageId1, 'product');
            }

            if ($request->hasFile('image2') && $request->statusEdited2 == 'edited') {
                if (isset($request->crop_x2) && isset($request->crop_y2) && isset($request->crop_width2) && isset($request->crop_height2)) {
                    $this->saveUploadImage($request->crop_x2, $request->crop_y2, $request->crop_width2, $request->crop_height2, $request->file('image2'), $request->imageId2, 'product', $request->description_image2, ['type' => 'product', 'product_id' => $id]);
                }
            } else if ($request->descriptionEdited2 == 'edited') {
                $this->updateDescription($request->imageId2, $request->description_image2);
            } else if ($request->statusEdited2 == 'deleted') {
                $this->deleteImage($request->imageId2, 'product');
            }

            if ($request->hasFile('image3') && $request->statusEdited3 == 'edited') {
                if (isset($request->crop_x3) && isset($request->crop_y3) && isset($request->crop_width3) && isset($request->crop_height3)) {
                    $this->saveUploadImage($request->crop_x3, $request->crop_y3, $request->crop_width3, $request->crop_height3, $request->file('image3'), $request->imageId3, 'product', $request->description_image3, ['type' => 'product', 'product_id' => $id]);
                }
            } else if ($request->descriptionEdited3 == 'edited') {
                $this->updateDescription($request->imageId3, $request->description_image3);
            } else if ($request->statusEdited3 == 'deleted') {
                $this->deleteImage($request->imageId3, 'product');
            }


            return redirect()->route('landing-page-settings.product')->with('success', 'Edit product success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function updateDescription($id, $description)
    {
        $image = Image::find($id);
        if (!$image) {
            throw new \Exception('Image not found');
        }
        Image::where('id', $id)->update([
            'description' => $description,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            $product = Product::find($id);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            //delete product
            Product::where('id', $id)->delete();

            //delete image
            $productImages = ProductImage::where('product_id', $id)->get();

            $imageIds = array_column($productImages->toArray(), 'image_id');

            foreach ($imageIds as $imageId) {
                $this->deleteImage($imageId, 'product');
            }

            return redirect()->back()->with('success', 'Delete product success');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
