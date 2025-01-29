<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\BlogCategory;
use App\Models\BlogImage;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $blogs = Blog::with('blogCategory', 'user')->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            //show only active user
            $blogs = Blog::with('blogCategory', 'user')->whereHas('user', function ($query)  {
                $query->where('active', 1);
            })->orderBy('created_at', 'desc')->paginate(10);
        }

        $page_name = 'Blogs';
        $breadcrumbs = [
            ['value' => 'Blogs', 'url' => ''],
        ];

        return view('dashboard.views.blogs.index-blogs', compact('blogs', 'page_name', 'breadcrumbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategories = BlogCategory::all();
        $page_name = 'Create Blog';
        $breadcrumbs = [
            ['value' => 'Blogs', 'url' => 'blogs.index'],
            ['value' => 'Create Blog', 'url' => ''],
        ];
        return view('dashboard.views.blogs.create-edit-blogs', compact('blogCategories', 'page_name', 'breadcrumbs'));
    }

    private function handleContentImages($content)
    {
        // Bungkus konten dengan tag HTML jika belum lengkap
        $wrappedContent = '<!DOCTYPE html><html><body>' . $content . '</body></html>';

        $dom = new \DOMDocument();
        // Supress warnings karena `loadHTML` bisa memunculkan error untuk HTML tidak valid
        @$dom->loadHTML($wrappedContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        $imagePaths = [];
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Simpan hanya path yang relevan
            if ($src && strpos($src, '/images/') !== false) {
                $imagePaths[] = $src;
            }
        }

        return $imagePaths;
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

    public function deleteImageBlogs(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file_path' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $image = Image::where('path', $request->file_path)->first();
            $imageId = $image->id;
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }

            if (file_exists(public_path($image->path))) {
                unlink(public_path($image->path));
            }
            Image::where('id', $imageId)->delete();

            //delete image from blog_images
            BlogImage::where('image_id', $imageId)->delete();

            return response()->json(['success' => true, 'message' => 'File berhasil dihapus.']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validtor = Validator::make($request->all(), [
                'title' => 'required|string',
                'content' => 'required',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'crop_x' => 'required|numeric',
                'crop_y' => 'required|numeric',
                'crop_width' => 'required|numeric',
                'crop_height' => 'required|numeric',
            ]);

            if ($validtor->fails()) {
                return redirect()->back()->withErrors($validtor)->withInput();
            }

            $imageContent = $this->handleContentImages($request->content);

            $uploadImage = null;
            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $uploadImage = $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), null, 'blog', $request->title);
                }
            }

            $blog = Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'blog_category_id' => $request->blog_category_id,
                'image_id' => $uploadImage['image_id'],
                'slug' => Str::slug($request->title),
                'user_id' => auth()->user()->id
            ]);

            //save image to blog_images
            $imageId = [];
            if (!empty($imageContent)) {
                $image = Image::whereIn('path', $imageContent)->get();
                foreach ($image as $img) {
                    $imageId[] = $img->id;
                }
            }
            array_push($imageId, $uploadImage['image_id']);

            foreach ($imageId as $id) {
                BlogImage::create([
                    'blog_id' => $blog->id,
                    'image_id' => $id
                ]);
            }

            return redirect()->route('blogs.index')->with('success', 'Berhasil menambahkan blog');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
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
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $blog = Blog::with('blogCategory', 'user', 'image')->find($id);
            if (!$blog) {
                return redirect()->back()->with('error', 'Blog not found');
            }
            $blogCategories = BlogCategory::all();
            $page_name = 'Edit Blog';
            $breadcrumbs = [
                ['value' => 'Blogs', 'url' => 'blogs.index'],
                ['value' => 'Edit Blog', 'url' => ''],
            ];
            return view('dashboard.views.blogs.create-edit-blogs', compact('blog', 'blogCategories', 'page_name', 'breadcrumbs'));
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
            $blog = Blog::find($id);
            if (!$blog) {
                return redirect()->back()->with('error', 'Blog not found');
            }

            $validtor = Validator::make($request->all(), [
                'title' => 'required|string',
                'content' => 'required',
                'blog_category_id' => 'required|exists:blog_categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'crop_x' => 'nullable|numeric',
                'crop_y' => 'nullable|numeric',
                'crop_width' => 'nullable|numeric',
                'crop_height' => 'nullable|numeric',
            ]);

            if ($validtor->fails()) {
                return redirect()->back()->withErrors($validtor)->withInput();
            }

            $uploadImage = null;
            $imageId = [];
            if ($request->hasFile('image')) {
                if (isset($request->crop_x) && isset($request->crop_y) && isset($request->crop_width) && isset($request->crop_height)) {
                    $uploadImage = $this->saveUploadImage($request->crop_x, $request->crop_y, $request->crop_width, $request->crop_height, $request->file('image'), $blog->image, 'blog', $request->title);
                    array_push($imageId, $uploadImage['image_id']);
                }
            }

            //chek image content
            $imageContent = $this->handleContentImages($request->content);
            if (!empty($imageContent)) {
                $image = Image::whereIn('path', $imageContent)->get();
                if (!empty($image)) {
                    foreach ($image as $img) {
                        $imageId[] = $img->id;
                    }
                }
            }

            foreach ($imageId as $id) {
                //check image exist in blog_images
                $blogImage = BlogImage::where('blog_id', $blog->id)->where('image_id', $id)->first();
                if (!$blogImage) {
                    BlogImage::create([
                        'blog_id' => $blog->id,
                        'image_id' => $id
                    ]);
                }
            }

            $blog->update([
                'title' => $request->title,
                'content' => $request->content,
                'blog_category_id' => $request->blog_category_id,
                'image_id' => $uploadImage ? $uploadImage['image_id'] : $blog->image_id,
                'slug' => Str::slug($request->title),
                'user_id' => auth()->user()->id
            ]);

            return redirect()->route('blogs.index')->with('success', 'Berhasil mengubah blog');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $id = decrypt($id);
            $blog = Blog::find($id);
            if (!$blog) {
                return redirect()->back()->with('error', 'Blog not found');
            }

            //delete image from blog_images
            $blogImages = BlogImage::where('blog_id', $id)->get();
            if (!empty($blogImages)) {
                $blogImageId = $blogImages->pluck('image_id')->toArray();
                $images = Image::whereIn('id', $blogImageId)->get();
                foreach ($images as $image) {
                    // dd($image, file_exists(public_path($image->path)));
                    if (file_exists(public_path($image->path))) {
                        unlink(public_path($image->path));
                    }
                    Image::where('id', $image->id)->delete();
                }
                BlogImage::where('blog_id', $id)->delete();
            }
            //delete blog
            $blog->delete();

            DB::commit();
            return redirect()->route('blogs.index')->with('success', 'Berhasil menghapus blog');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
