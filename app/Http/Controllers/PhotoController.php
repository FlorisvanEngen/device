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
    public function store(Request $request, Device $device)
    {
        $attributes = $request->validate([
            'photo_path' => ['image']
        ]);

        $attributes['device_id'] = $device->id;

        if (isset($attributes['photo_path'])) {
            $file = $request->file('photo_path');
            $attributes['name'] = $file->getClientOriginalName();
            $attributes['photo_path'] = $file->store('img');
        }

        Photo::create($attributes);

        return redirect('/devices/' . $device->id . '/edit')->with('success', 'The photo has been added!');
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
