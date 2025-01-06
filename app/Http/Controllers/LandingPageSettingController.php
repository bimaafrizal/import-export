<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LandingPageSettingController extends Controller
{
    public function index()
    {
        $landingPageSetting = LandingPage::where('id', 1)->first();
        return view('dashboard.views.landing-page-setting.index-landing-page-setting', compact('landingPageSetting'));
    }

    public function updateHome(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'sub_title' => 'required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
                'crop_x' => 'nullable|integer',
                'crop_y' => 'nullable|integer',
                'crop_width' => 'nullable|integer',
                'crop_height' => 'nullable|integer',
            ]);

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $imageId = null;
            $logoPath = null;
            $landingPageSettings = LandingPage::where('id', 1)->first();
            // dd($request->has('image'), isset($request->crop_x), isset($request->crop_y), isset($request->crop_width), isset($request->crop_height), $request->all());
            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $pathOldImage = null;

                    $oldImage = Image::where('id', $landingPageSettings->image_id)->first();
                    if (!empty($oldImage)) {
                        $pathOldImage = $oldImage->path;
                    }

                    $crop = [
                        'x' => $request->crop_x,
                        'y' => $request->crop_y,
                        'width' => $request->crop_width,
                        'height' => $request->crop_height,
                    ];

                    $uploadImage = $this->uploadImage($pathOldImage, $request->file('image'), $crop);
                    $path = $uploadImage['path'];
                    $imageName = $uploadImage['name'];

                    //delete old image
                    $imageId = $landingPageSettings->image_id;
                    if (!$imageId) {
                        //create new image
                        $newImage = Image::create([
                            'path' => $path,
                            'name' => $imageName,
                            'type' => 'hero'
                        ]);
                        $imageId = $newImage->id;
                    } else {
                        Image::where('id', $imageId)->update([
                            'name' => $imageName,
                            'path' => $path,
                        ]);
                    }
                }
            }

            if ($request->hasFile('logo')) {
                $uploadLogo = $this->uploadImage($landingPageSettings->logo, $request->file('logo'));
                $logoPath = $uploadLogo['path'];
            }

            $update = [
                'title' => $request->title,
                'sub_title' => $request->sub_title,
            ];
            if (!empty($imageId)) {
                $update['image_id'] = $imageId;
            }

            if (!empty($logoPath)) {
                $update['logo'] = $logoPath;
            }

            LandingPage::where('id', 1)->update($update);

            return redirect()->back()->with('success', 'Home setting updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
