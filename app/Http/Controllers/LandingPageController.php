<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Http\Requests\StoreLandingPageRequest;
use App\Http\Requests\UpdateLandingPageRequest;
use App\Models\AboutUs;
use App\Models\Image;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $landingPage = LandingPage::where('id', 1)->first()->toArray();
        $landingPage['hero_image'] = null;
        if (!empty($landingPage['image_id'])) {
            $imageId = [$landingPage['image_id']];
        }

        $aboutUs = AboutUs::where('id', 1)->first();
        if (!empty($aboutUs)) {
            $aboutUs = $aboutUs->toArray();
            if (!empty($aboutUs['image_id'])) {
                $imageId[] = $aboutUs['image_id'];
            }

            $aboutUs['content'] = preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $aboutUs['content']);
            $aboutUs['content'] = nl2br($aboutUs['content']);
        }
        $images = Image::whereIn('id', $imageId)->get();
        // check path image to check the file exists
        foreach ($images as $image) {
            if (file_exists(public_path($image->path))) {
                if($image->type == 'hero') {
                    $landingPage['hero_image'] = $image->path;
                } else if($image->type == 'about_us') {
                    $aboutUs['image'] = $image->path;
                }
            }
        }

        return view('landing-pages.view.index', compact('landingPage', 'aboutUs'));
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
    public function store(StoreLandingPageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LandingPage $landingPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandingPage $landingPage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLandingPageRequest $request, LandingPage $landingPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandingPage $landingPage)
    {
        //
    }
}
