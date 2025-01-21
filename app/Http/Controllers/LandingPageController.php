<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Http\Requests\StoreLandingPageRequest;
use App\Http\Requests\UpdateLandingPageRequest;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\Image;
use App\Models\Product;
use App\Models\Team;
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

        // Ambil semua gambar sekaligus
        $images = Image::whereIn('id', $imageIds->unique())
            ->orWhere('type', 'gallery')
            ->orWhere('type', 'blog')
            ->where('show_gallery', 1)
            ->get()
            ->keyBy('id'); // Optimalkan dengan keyBy untuk akses cepat

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
                    $galleries[] = [
                        'path' => $image->path,
                        'description' => $image->description ?: '-',
                    ];
                }
            });
        });

        //tambahkan gambar blog pada gallery
        $blogImages = $images->filter(fn($image) => $image->type === 'blog');
        foreach ($blogImages as $blogImage) {
            $galleries[] = [
                'path' => $blogImage->path,
                'description' => $blogImage->description ?: '-',
            ];
        }

        // Tambahkan gambar pada tim
        $teams->each(function ($team) use ($images) {
            if ($images->has($team->image_id)) {
                $team->image = $images[$team->image_id]->path;
            }
        });

        // Tambahkan gambar galeri
        $galleryImages = $images->filter(fn($image) => $image->type === 'gallery');
        foreach ($galleryImages as $galleryImage) {
            $galleries[] = [
                'path' => $galleryImage->path,
                'description' => $galleryImage->description ?: '-',
            ];
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
        ]);
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
