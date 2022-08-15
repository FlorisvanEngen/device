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
use function MongoDB\BSON\toJSON;

class ContactController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index()
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

    /**
     * @param $category
     * @return array
     */
    public function getDevices($category)
    {
        try {
            $devices = Device::without('category')
                ->where('category_id', $category)
                ->orderBy('name')
                ->get(['id', 'name']);
            return ['success' => true, 'devices' => $devices];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errorMsg' => $e->getMessage()];
        }
    }

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendMail(ContactRequest $request)
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
