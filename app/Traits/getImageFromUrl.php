<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait getImageFromURL
{
    public function getImage($url,$path)  {
        $contents = file_get_contents($url);
            $name = substr($url, strrpos($url, '/') + 1);
            $local = '/'.$path.'/'.Str::uuid().strrchr($name, '.');
            Storage::disk('public')->put($local, $contents);
            $host = request()->getHttpHost();
            $img = Image::create([
                'src'=>$host,
                'local_src'=>$local,
            ]);

            return $img->id;
    }
}

?>