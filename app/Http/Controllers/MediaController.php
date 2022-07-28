<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * @param $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($filename)
    {
        try {
            $filetype = 'pdf';
            if ($filetype != pathinfo($filename, PATHINFO_EXTENSION))
                $filetype = 'img';

            $path = $filetype . '/' . $filename;

            if (!Storage::exists($path)) {
                abort(404);
            }

            $path = Storage::path($path);

            if ($filetype === 'pdf') {
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ];
            } else {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $headers = ['Content-Type' => $type];
            }

            return response()->file($path, $headers);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param Request $request
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Device $device)
    {
        try {
            $attributes = $request->validate([
                'path' => ['image']
            ]);

            $file = $request->file('path');
            $attributes['device_id'] = $device->id;
            $attributes['name'] = $file->getClientOriginalName();
            $attributes['type'] = 'img';
            $attributes['path'] = str_replace('img/', '', $file->store('img'));

            Media::create($attributes);

            return redirect('/devices/' . $device->id . '/edit')->with('success', 'The photo has been added!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'Something went wrong!');
        }

        return back();
    }

    /**
     * @param Request $request
     * @param Media $media
     * @return array|bool[]
     */
    public function destroy(Request $request, Media $media)
    {
        try {
            Storage::delete($media->type . '/' . $media->path);
            $media->delete();
            Device::find($media->device_id)->update(['edited_by_id' => $request->user()->id]);

            return ['success' => true, 'type' => $media->type];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $errorMsg = $e->getMessage();
        }
        return ['success' => false, 'errorMsg' => $errorMsg];
    }
}
