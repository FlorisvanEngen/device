<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
    public function store(Request $request)
    {
        $file = null;
        $attributes = $this->validateDevice($request);

        $attributes['created_by_id'] = $request->user()->id;

        if (isset($attributes['pdf'])) {
            $file = $request->file('pdf');
            unset($attributes['pdf']);
        }

        $device = Device::create($attributes);

        if ($file) {
            $pdf = Media::create([
                'device_id' => $device->id,
                'name' => $file->getClientOriginalName(),
                'type' => 'pdf',
                'path' => $this->uploadFile($file)
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
    public function edit(Device $device)
    {
        $categories = Category::get();
        $photos = Media::where('device_id', $device->id)->where('type', 'img')->get();

        return view('pages.devices.edit', compact('device', 'categories', 'photos'));
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Device $device)
    {
        $attributes = $this->validateDevice($request, $device);

        $attributes['edited_by_id'] = $request->user()->id;
        $attributes['updated_at'] = time();

        if (isset($attributes['pdf'])) {
            $file = $request->file('pdf');

            $pdf = Media::create([
                'device_id' => $device->id,
                'name' => $file->getClientOriginalName(),
                'type' => 'pdf',
                'path' => $this->uploadFile($file)
            ]);

            $device->pdf()->associate($pdf);
            $device->save();
            unset($attributes['pdf']);
        }

        $device->update($attributes);

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

    /**
     * @return array
     */
    protected function validateDevice(Request $request, ?Device $device = null)
    {
        $device ??= new Device();

        return $request->validate([
            'name' => ['required', 'max:30', Rule::unique('devices', 'name')->ignore($device->id)],
            'pdf' => ['nullable', 'file'],
            'description' => ['required'],
            'order' => ['required', 'numeric'],
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);
    }

    /**
     * @param $file
     * @return mixed
     * @throws ValidationException
     */
    protected function uploadFile($file)
    {
        if ($file->getClientMimeType() == 'application/pdf') {
            return str_replace('pdf/', '', $file->store('pdf'));
        } else {
            throw ValidationException::withMessages(['pdf' => 'The file must ba a PDF.']);
        }
    }
}
