<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Http\Requests\StoreLandingPageRequest;
use App\Http\Requests\UpdateLandingPageRequest;
use App\Models\AboutUs;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data landing page
        $landingPage = LandingPage::find(1);
        $landingPageData = $landingPage ? $landingPage->toArray() : [];
        $landingPageData['hero_image'] = null;

        // Kumpulkan semua ID gambar
        $imageIds = collect();
        if (!empty($landingPageData['image_id'])) {
            $imageIds->push($landingPageData['image_id']);
        }

        // Ambil data About Us
        $aboutUs = AboutUs::find(1);
        $aboutUsData = [];
        if ($aboutUs) {
            $aboutUsData = $aboutUs->toArray();
            if (!empty($aboutUsData['image_id'])) {
                $imageIds->push($aboutUsData['image_id']);
            }
            $aboutUsData['content'] = nl2br(preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $aboutUsData['content']));
        }

        // Ambil produk dan gambar terkait
        $products = Product::with('productImages')->get();
        $products->each(function ($product) use ($imageIds) {
            $product->productImages->each(function ($image) use ($imageIds) {
                $imageIds->push($image->image_id);
            });
        });

        // Ambil data tim
        $teams = Team::all();
        $imageIds = $imageIds->merge($teams->pluck('image_id'));

        //blog
        $blogs = Blog::with('blogCategory', 'user')->whereHas('user', function ($query) {
            $query->where('active', 1);
        });
        $blogCount = $blogs->count();
        $blogs = $blogs->limit(3)->orderBy('created_at', 'desc')->get();
        $imageIds = $imageIds->merge($blogs->pluck('image_id'));

        // Ambil semua gambar sekaligus
        $images = Image::whereIn('id', $imageIds->unique())
            ->orWhere('type', 'gallery')
            ->orWhere('type', 'blog')
            ->orWhere('type', 'product')
            ->orWhere('type', 'team')
            ->orWhere('type', 'about_us')
            ->orWhere('type', 'hero')
            ->get()
            ->keyBy('id'); // Optimalkan dengan keyBy untuk akses cepat
        // dd($images);

        // Proses gambar untuk landing page
        if (!empty($landingPageData['image_id']) && $images->has($landingPageData['image_id'])) {
            $landingPageData['hero_image'] = $images[$landingPageData['image_id']]->path;
        }

        // Proses gambar untuk About Us
        if (!empty($aboutUsData['image_id']) && $images->has($aboutUsData['image_id'])) {
            $aboutUsData['image'] = $images[$aboutUsData['image_id']]->path;
        }

        // Tambahkan gambar pada produk
        $galleries = [];
        $products->each(function ($product) use ($images, &$galleries) {
            $product->productImages->each(function ($productImage) use ($images, &$galleries) {
                if ($images->has($productImage->image_id)) {
                    $image = $images[$productImage->image_id];
                    $productImage->image = $image->path;
                    $productImage->description = nl2br(preg_replace('/\\r\\n|\\r|\\n/', "\r\n", $image->description));
                    if ($image->show_gallery == 1) {
                        $galleries[] = [
                            'path' => $image->path,
                            'description' => $image->description ?: '-',
                        ];
                    }
                }
            });
        });

        //tambahkan gambar blog pada gallery
        $blogImages = $images->filter(fn($image) => $image->type === 'blog');
        foreach ($blogImages as $blogImage) {
            if ($blogImage->show_gallery == 1) {
                $galleries[] = [
                    'path' => $blogImage->path,
                    'description' => $blogImage->description ?: '-',
                ];
            }
        }

        // Tambahkan gambar pada tim
        $teams->each(function ($team) use ($images) {
            if ($images->has($team->image_id)) {
                $team->image = $images[$team->image_id]->path;
            }
        });

        //blog image
        $blogs->each(function ($blog) use ($images) {
            if ($images->has($blog->image_id)) {
                $blog->image = $images[$blog->image_id]->path;
            }
            //convert created_at to human readable
            $blog->created_at = $blog->created_at->diffForHumans();
        });

        // Tambahkan gambar galeri
        $galleryImages = $images->filter(fn($image) => $image->type === 'gallery');
        foreach ($galleryImages as $galleryImage) {
            if ($galleryImage->show_gallery == 1) {
                $galleries[] = [
                    'path' => $galleryImage->path,
                    'description' => $galleryImage->description ?: '-',
                ];
            }
        }

        // Ambil kontak
        $contacts = Contact::where('landing_page_id', 1)->get();
        $socialMedias = $contacts->where('type', 'social-media');
        $requiredContacts = $contacts->whereNotIn('type', ['social-media'])->keyBy('type');

        return view('landing-pages.view.index', [
            'landingPage' => $landingPageData,
            'aboutUs' => $aboutUsData,
            'products' => $products,
            'teams' => $teams,
            'socialMedias' => $socialMedias,
            'requiredContacts' => $requiredContacts,
            'galleries' => $galleries,
            'blogs' => $blogs,
            'blogCount' => $blogCount,
        ]);
    }

    public function blogDetail($slug)
    {
        try {
            $blog = Blog::with('blogCategory', 'user')->where('slug', $slug)->whereHas('user', function ($query) {
                $query->where('active', 1);
            })->firstOrFail();
            $image = Image::find($blog->image_id);
            $blog->image = $image->path;
            $blog->created_at = $blog->created_at->diffForHumans();
            $landingPage = LandingPage::find(1);

            $contacts = Contact::where('landing_page_id', 1)->get();
            $socialMedias = $contacts->where('type', 'social-media');
            $requiredContacts = $contacts->whereNotIn('type', ['social-media'])->keyBy('type');

            return view('landing-pages.view.detail-blog', [
                'blog' => $blog,
                'socialMedias' => $socialMedias,
                'requiredContacts' => $requiredContacts,
                'landingPage' => $landingPage,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('index');
        }
    }


    public function blog()
    {
        try {
            $blogs = Blog::with('blogCategory', 'user', 'image')->whereHas('user', function ($query) {
                $query->where('active', 1);
            });
            //search name blog, name category or user
            if (request()->has('search')) {
                $search = request()->search;
                $blogs = $blogs->where('title', 'like', "%$search%")
                    ->orWhereHas('blogCategory', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });
            }

            $blogs = $blogs->orderBy('created_at', 'desc')->simplePaginate(6);
            $landingPage = LandingPage::find(1);

            $contacts = Contact::where('landing_page_id', 1)->get();
            $socialMedias = $contacts->where('type', 'social-media');
            $requiredContacts = $contacts->whereNotIn('type', ['social-media'])->keyBy('type');

            return view('landing-pages.view.all-blog', [
                'blogs' => $blogs,
                'socialMedias' => $socialMedias,
                'requiredContacts' => $requiredContacts,
                'landingPage' => $landingPage,
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('index');
        }
    }


    public function sendMail(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $contacts = Contact::where('landing_page_id', 1)->get();
        $requiredContacts = $contacts->whereNotIn('type', ['social-media'])->keyBy('type');

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            Mail::to($requiredContacts['email']->value)->send(new \App\Mail\ContactMail($data));

            //save notification
            Notification::create([
                'title' => 'Pesan Baru',
                'content' => 'Anda mendapat pesan baru dari ' . $request->name,
                'type' => 'email',
            ]);
            return response()->json(['message' => 'Email berhasil dikirim'], 200);
        } catch (\Exception $e) {
            // \Log::error('Email Error: ' . $e->getMessage());
            return response()->json(['message' => 'Email gagal dikirim'], 500);
        }
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
