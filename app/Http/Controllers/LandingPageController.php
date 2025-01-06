<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Http\Requests\StoreLandingPageRequest;
use App\Http\Requests\UpdateLandingPageRequest;
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
            $image = Image::where('id', $landingPage['image_id'])->first();
            //check path image to check the file exists
            if (file_exists(public_path($image->path))) {
                $landingPage['hero_image'] = $image->path;
            }
        }

        return view('landing-pages.view.index', compact('landingPage'));
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
