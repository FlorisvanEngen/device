<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PDFController extends Controller
{
    /**
     * @param $filename
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function show($filename)
    {
        $path = 'pdf/' . $filename;

        if (!Storage::exists($path)) {
            abort(404);
        }

        $path = Storage::path($path);
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ];

        return response()->file($path, $headers); //->header('Content-Type', $type);
    }

    /**
     * @param Device $device
     * @return bool[]
     */
    public function destroy(Device $device)
    {
        $attributes = request()->validate([
            'edited_by_id' => ['required', Rule::exists('users', 'id')]
        ]);

        Storage::delete($device->pdf_path);

        $attributes['pdf_name'] = null;
        $attributes['pdf_path'] = null;
        $attributes['updated_at'] = time();
        $device->update($attributes);

        return ['success' => true];
    }
}
