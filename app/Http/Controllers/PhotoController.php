<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Device $device)
    {
        $attributes = request()->validate([
            'photo_path' => 'image'
        ]);

        $attributes['device_id'] = $device->id;

        if (isset($attributes['photo_path'])) {
            $attributes['photo_path'] = request()->file('photo_path')->store('img');
        }

        Photo::create($attributes);

        return redirect('/devices/' . $device->id)->with('success', 'The photo has been added!');
    }

    /**
     * @param Photo $photo
     * @return array
     */
    public function destroy(Photo $photo)
    {
        Storage::delete($photo->photo_path);

        $photo->delete();

        return ['success' => true, 'photoId' => $photo->id];
    }
}
