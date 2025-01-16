<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $images = Image::whereIn('type', ['gallery', 'product'])->simplePaginate(10);

        //rubah description
        foreach ($images as $image) {
            $image->description = preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $image->description);
            $image->description = nl2br($image->description);
        }
        return view('dashboard.views.landing-page-setting.gallery.index-gallery', compact('images'));
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string',
                'crop_x' => 'required|numeric',
                'crop_y' => 'required|numeric',
                'crop_width' => 'required|numeric',
                'crop_height' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), null,  'gallery', $request->description);
                }
            }

            return redirect()->back()->with('success', 'Berhasil menambahkan gambar');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
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
            $image = Image::find($id);
            if (!$image) {
                throw new \Exception('Gambar tidak ditemukan');
            }

            return view('dashboard.views.landing-page-setting.gallery.edit-gallery', compact('image'));
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
            $id = decrypt($id);
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string',
                'crop_x' => 'required|numeric',
                'crop_y' => 'required|numeric',
                'crop_width' => 'required|numeric',
                'crop_height' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), $id,  'gallery', $request->description);
                }
            } else {
                Image::where('id', $id)->update([
                    'description' => $request->description,
                ]);
            }

            return redirect()->route('landing-page-settings.gallery.index')->with('success', 'Berhasil mengubah gambar');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $id = decrypt($id);
            $image = Image::find($id);
            if (!$image) {
                throw new \Exception('Gambar tidak ditemukan');
            }

            if ($image->show_gallery == 1) {
                $image->show_gallery = 0;
            } else {
                $image->show_gallery = 1;
            }
            $image->save();

            return redirect()->back()->with('success', 'Berhasil mengubah status gambar');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            $this->deleteImage($id, "gallery");

            return redirect()->back()->with('success', 'Berhasil menghapus gambar');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
