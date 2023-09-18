<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('image');
        $fileName = hexdec(uniqid()) . '.' . $file->extension();
        $folder = uniqid() . '-' . now()->timestamp;

        $file->storeAs('posts/' . $folder, $fileName);

        Image::create([
            'posts_id' => null,
            'folder'   => $folder,
            'image'    => $fileName
        ]);

        return $fileName;
    }

    public function destroy(Request $request)
    {
        $data = Image::where('image', $request->image)->first();

        if ($data) {
            $path = public_path('storage/posts/' . $data->folder . '/' . $data->image);
            if (File::exists($path)) {
                File::delete($path);
                rmdir(public_path('storage/posts/' . $data->folder));

                Image::where([
                    'folder' => $data->folder,
                    'image'  => $data->image
                ])->delete();

                return 'deleted';
            } else {
                return 'not found';
            }
        }
    }
}
