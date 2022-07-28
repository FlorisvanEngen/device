<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Category;
use App\Models\Device;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        try {
            $currentCategory = Category::with('devices')->find($request['category']);

            if (!isset($currentCategory)) {
                $currentCategory = Category::with('devices')->first();
            }

            $categories = Category::get();
            $devices = $currentCategory->devices()->paginate(20)->withQueryString();
            return view('pages.devices.index', compact('devices', 'categories', 'currentCategory'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($device)
    {
        try {
            $categories = Category::get();
            $device = Device::with('photos')->find($device);
            return view('pages.devices.show', compact('device', 'categories'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        try {
            $categories = Category::get();
            $currentCategory = Category::find($request['category']);
            $maxOrder = Device::where('category_id', $request['category'])->max('order') + 1;

            return view('pages.devices.create', compact('maxOrder', 'categories', 'currentCategory'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param DeviceRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DeviceRequest $request)
    {
        try {
            $device = Device::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'order' => $request->order,
                'description' => $request->description,
                'created_by_id' => $request->user()->id
            ]);

            if ($request->pdf) {
                $file = $request->file('pdf');
                $pdf = Media::create([
                    'device_id' => $device->id,
                    'name' => $file->getClientOriginalName(),
                    'type' => 'pdf',
                    'path' => str_replace('pdf/', '', $file->store('pdf'))
                ]);

                $device->pdf()->associate($pdf);
                $device->save();
            }

            return redirect('/devices/' . $device->id)->with('success', 'The device has been added!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return back()->with('error', 'Something went wrong!');
    }

    /**
     * @param $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($device)
    {
        try {
            $categories = Category::get();
            $device = Device::with('photos')->find($device);
            return view('pages.devices.edit', compact('device', 'categories'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param DeviceRequest $request
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DeviceRequest $request, Device $device)
    {
        try {
            $device->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'order' => $request->order,
                'description' => $request->description,
                'edited_by_id' => $request->user()->id
            ]);

            if ($request->pdf) {
                $file = $request->file('pdf');

                $pdf = Media::create([
                    'device_id' => $device->id,
                    'name' => $file->getClientOriginalName(),
                    'type' => 'pdf',
                    'path' => str_replace('pdf/', '', $file->store('pdf'))
                ]);

                $device->pdf()->associate($pdf);
                $device->save();
            }

            return redirect('/devices/' . $device->id . '/edit')->with('success', 'The device \'' . $device->name . '\' has been updated!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return back()->with('error', 'Something went wrong!');
    }

    /**
     * @param $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($device)
    {
        try {
            $device = Device::with('media')->first($device);

            foreach ($device->media as $m) {
                Storage::delete($m->type . '/' . $m->path);
            }

            $device->delete();
            return redirect('/?category=' . $device->category_id)->with('success', 'The device \'' . $device->name . '\' has been deleted!');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return back()->with('error', 'Something went wrong!');
    }
}
