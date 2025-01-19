<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\BlogCategory;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::paginate(10);

        return view('dashboard.views.blogs.index-blogs', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategories = BlogCategory::all();
        return view('dashboard.views.blogs.create-edit-blogs', compact('blogCategories'));
    }

    public function uploadImageContentBlogs(Request $request)
    {
        try {
            if (!$request->hasFile('upload')) {
                return response()->json(['error' => 'Failed to upload image'], 422);
            }

            $image = $this->uploadImage(null, $request->file('upload'));

            //save image
            $image = Image::create([
                'name' => $image['name'],
                'path' => $image['path'],
                'type' => 'content-blog'
            ]);

            return response()->json([
                'filename' => $image['name'],
                'uploaded' => 1,
                'url' => $image['path']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteImageBlogs(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'file_path' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $image = Image::where('path', $request->file_path)->first();
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            if (file_exists(public_path($image->path))) {
                unlink(public_path($image->path));
            }
            Image::where('path', $request->file_path)->delete();
            return response()->json(['success' => true, 'message' => 'File berhasil dihapus.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
