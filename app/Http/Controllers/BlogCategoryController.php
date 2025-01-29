<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogCategories = BlogCategory::paginate(10);
        $page_name = 'Blog Categories';
        $breadcrumbs = [
            ['value' => 'Blog Categories', 'url' => ''],
        ];

        return view('dashboard.views.blog-categories.index-blog-categories', compact('blogCategories', 'page_name', 'breadcrumbs'));
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

            $page_name = 'Edit Blog Category';
            $breadcrumbs = [
                ['value' => 'Blog Categories', 'url' => 'blog-categories.index'],
                ['value' => 'Edit Blog Category', 'url' => ''],
            ];

            return view('dashboard.views.blog-categories.edit-blog-categories', compact('blogCategory', 'page_name', 'breadcrumbs'));
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
            //cek apakah blog category ini memiliki blog post
            $blog = Blog::where('blog_category_id', $blogCategory->id)->first();
            if ($blog) {
                return redirect()->route('blog-categories.index')->with('error', 'Failed to delete blog category, because this blog category has blog post');
            }
            $blogCategory->delete();
            return redirect()->route('blog-categories.index')->with('success', 'Blog category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog-categories.index')->with('error', 'Failed to delete blog category');
        }
    }
}
