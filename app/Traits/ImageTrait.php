<?php

namespace App\Traits;
use Intervention\Image\Facades\Image as Intervention;
trait ImageTrait
{

    public function upload_image($image,string $dir) :string
    {
        $photoName = uniqid() . '.' . $image->extension();
        $image->move(public_path("images/$dir"),$photoName);  
        return $photoName;
    }

    public function delete_image($image,string $dir) :bool
    {
        $oldPhotoPath = public_path("images/$dir/$image");
        if (file_exists($oldPhotoPath)) {
            unlink($oldPhotoPath);
            return true;
        }
        return false;
    }

    public static function get_image($image,string $dir) 
    {
        $photoPath = public_path("images/$dir/$image");
        return $photoPath;
    }
}