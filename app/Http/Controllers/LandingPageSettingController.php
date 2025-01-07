<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
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
            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                   $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), $landingPageSettings->image_id, 'hero');
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


    public function aboutUs()
    {
        $aboutUs = AboutUs::where('id', 1)->first();
        return view('dashboard.views.landing-page-setting.about_us-landing-page-setting', compact('aboutUs'));
    }

    public function updateAboutUs(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'content' => 'required|string',
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

            $aboutUs = AboutUs::where('id', 1)->first();
            $imageId = null;
            if(!empty($aboutUs)) {
                $imageId = $aboutUs->image_id;
                $update = [
                    'title' => $request->title,
                    'content' => $request->content,
                ];

                AboutUs::where('id', 1)->update($update);
            }

            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $imageId = $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), $imageId, 'about_us');
                }
            }

            if(empty($aboutUs)) {
                AboutUs::create([
                    'title' => $request->title,
                    'content' => $request->content,
                    'landing_page_id' => 1,
                    'image_id' => $imageId,
                ]);
            }


            return redirect()->back()->with('success', 'About us setting updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
