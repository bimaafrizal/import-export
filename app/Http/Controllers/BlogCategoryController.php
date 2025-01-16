<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogCategories = BlogCategory::paginate(10);

        return view('dashboard.views.blog-categories.index-blog-categories', compact('blogCategories'));
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
            $validator = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            BlogCategory::create($validator);
            return redirect()->route('blog-categories.index')->with('success', 'Blog category created successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog-categories.index')->with('error', 'Failed to create blog category');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
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
            $blogCategory = BlogCategory::find($id);
            if (!$blogCategory) {
                return redirect()->route('blog-categories.index')->with('error', 'Blog category not found');
            }

            return view('dashboard.views.blog-categories.edit-blog-categories', compact('blogCategory'));
        } catch (\Exception $e) {
            return redirect()->route('blog-categories.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $id = decrypt($id);
            $blogCategory = BlogCategory::find($id);
            if (!$blogCategory) {
                return redirect()->route('blog-categories.index')->with('error', 'Blog category not found');
            }

            $validator = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $blogCategory->update($validator);
            return redirect()->route('blog-categories.index')->with('success', 'Blog category updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog-categories.index')->with('error', 'Failed to update blog category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
            $blogCategory = BlogCategory::find($id);
            if (!$blogCategory) {
                return redirect()->route('blog-categories.index')->with('error', 'Blog category not found');
            }
            $blogCategory->delete();
            return redirect()->route('blog-categories.index')->with('success', 'Blog category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog-categories.index')->with('error', 'Failed to delete blog category');
        }
    }
}
