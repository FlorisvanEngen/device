<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    /**
     * @param Device $device
     * @return bool[]
     */
    public function destroy(Device $device)
    {
//        TODO: bewerk de edited_by_id kolomen.

        Storage::delete($device->pdf_path);

        $device->pdf_path = null;
        $device->updated_at = time();
        $device->update();

        return ['success' => true];
    }
}
