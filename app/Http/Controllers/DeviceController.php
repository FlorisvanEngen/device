<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceRequest;
use App\Models\Category;
use App\Models\Device;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $currentCategory = Category::find($request['category']);

        if (!isset($currentCategory)) {
            $currentCategory = Category::with('devices')->first();
        }

        $categories = Category::get();
        $devices = $currentCategory->devices()->orderBy('order')->paginate(20)->withQueryString();
        return view('pages.devices.index', compact('devices', 'categories', 'currentCategory'));
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Device $device)
    {
        $categories = Category::get();
        $photos = Media::where('device_id', $device->id)->where('type', 'img')->get();

        return view('pages.devices.show', compact('device', 'categories', 'photos'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $categories = Category::get();
        $currentCategory = Category::find($request['category']);
        $maxOrder = Device::where('category_id', $request['category'])->max('order') + 1;

        return view('pages.devices.create', compact('maxOrder', 'categories', 'currentCategory'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DeviceRequest $request)
    {
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
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($device)
    {
        $device = Device::with('media')->find($device);
        $categories = Category::get();

        return view('pages.devices.edit', compact('device', 'categories'));
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(DeviceRequest $request, Device $device)
    {
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
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Device $device)
    {
        $media = Media::where('device_id', $device->id)->get();

        foreach ($media as $m) {
            Storage::delete($m->type . '/' . $m->path);
        }

        $device->delete();

        return redirect('/?category=' . $device->category_id)->with('success', 'The device \'' . $device->name . '\' has been deleted!');
    }
}
