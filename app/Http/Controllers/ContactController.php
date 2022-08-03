<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Category;
use App\Models\Device;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show($category)
    {
        try {
            $devices = Device::without('category')->where('category_id', $category)->orderBy('name')->get(['id', 'name']);

            $deviceOptions = '<option value="-1" selected disabled>Select a device</option>';
            foreach ($devices as $device) {
                $deviceOptions .= '<option value="' . $device->id . '">' . $device->name . '</option>';
            }

            return ['success' => true, 'deviceOptions' => $deviceOptions];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errorMsg' => $e->getMessage()];
        }
    }

    public function create()
    {
        try {
            $loggedInEmail = '';
            $user = Auth::user();
            $categories = Category::get();
            if (isset($user)) {
                $loggedInEmail = $user->email;
            }

            return view('pages.contact.create', compact('categories', 'loggedInEmail'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    public function store(ContactRequest $request)
    {
        try {
            $deviceName = '';
            $categoryName = '';

            if (isset($request->category_id)) {
                $category = Category::find($request->category_id);
                $categoryName = $category->name;
            }

            if (isset($request->device_id)) {
                $device = Device::without('category')->find($request->device_id);
                $deviceName = $device->name;
            }

            $mailData = [
                'Name' => $request->name,
                'email' => $request->email,
                'concern_type' => $request->concern_type,
                'category' => $categoryName,
                'device' => $deviceName,
                'text' => $request->text
            ];
            Mail::to('floris.van.engen@connectionsystems.nl')->send(new ContactMail($mailData));

            return redirect('/contact')->with('success', 'The e-mail has een send!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return back()->with('error', 'Something went wrong!');
    }
}
