<?php

namespace App\Http\Controllers;

use App\Models\BlogImage;
use App\Http\Requests\StoreBlogImageRequest;
use App\Http\Requests\UpdateBlogImageRequest;

class BlogImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreBlogImageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogImage $blogImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogImage $blogImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogImageRequest $request, BlogImage $blogImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogImage $blogImage)
    {
        //
    }
}
