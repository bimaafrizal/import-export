<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function uploadImage($oldFile, $newRequest, $crop = null)
    {
        if ($oldFile != null) {
            if (file_exists(public_path($oldFile))) {
                unlink(public_path($oldFile));
            }
        }

        $foto = $newRequest;
        $name = $foto->hashName();
        $directory = public_path('/images/landing-page/');
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        // Crop gambar jika data crop tersedia
        if ($crop) {
            $image = InterventionImage::read($foto); // Ganti make() dengan read()
            $image->crop($crop['width'], $crop['height'], $crop['x'], $crop['y']);
            $image->save(public_path('/images/landing-page/' . $name));
        } else {
            $foto->move($directory, $name);
        }

        return [
            'name' => $name,
            'path' => '/images/landing-page/' . $name,
        ];
    }

    public function saveUploadImage($crop_x, $crop_y, $crop_width, $crop_height, $requestImage, $imageId, $type): int
    {
        $pathOldImage = null;

        $oldImage = Image::where('id', $imageId)->first();
        if (!empty($oldImage)) {
            $pathOldImage = $oldImage->path;
        }

        $crop = [
            'x' => $crop_x,
            'y' => $crop_y,
            'width' => $crop_width,
            'height' => $crop_height,
        ];

        $uploadImage = $this->uploadImage($pathOldImage, $requestImage, $crop);
        $path = $uploadImage['path'];
        $imageName = $uploadImage['name'];

        if (empty($imageId)) {
            //create new image
            $newImage = Image::create([
                'path' => $path,
                'name' => $imageName,
                'type' => $type
            ]);
            $imageId = $newImage->id;
        } else {
            Image::where('id', $imageId)->update([
                'name' => $imageName,
                'path' => $path,
            ]);
        }

        return $imageId;
    }
}
