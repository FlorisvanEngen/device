<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Photo;
use Composer\Autoload\ClassLoader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use function GuzzleHttp\Promise\all;

class DeviceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $currentCategory = Category::firstWhere('id', request('category'));

        if (!isset($currentCategory)) {
            $currentCategory = Category::query()->orderBy('id')->first();
        }

        $categories = Category::all();
        $devices = Device::query()->orderBy('order')->filter(compact('currentCategory'))->paginate(20)->withQueryString();
        return view('pages.devices.index', compact('devices', 'categories', 'currentCategory'));
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Device $device)
    {
        return view('pages.devices.show', [
            'device' => $device,
            'categories' => Category::all(),
            'photos' => Photo::query()->where('device_id', '=', $device->id)->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $currentCategory = Category::query()->firstWhere('id', '=', $request['category']);

        $maxOrder = 0;
        $categories = Category::all();
        $lastDevice = Device::query()->where('category_id', '=', $request['category'])->orderByDesc('order')->first();

        if (isset($lastDevice)) {
            $maxOrder = $lastDevice->order + 1;
        }

        return view('pages.devices.create', compact('maxOrder', 'categories', 'currentCategory'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $attributes = $this->validateDevice();

        $attributes['created_by_id'] = request()->user()->id;

        if (isset($attributes['pdf_path'])) {
            $file = $request->file('pdf_path');
            $attributes['pdf_name'] = $file->getClientOriginalName();
            $attributes['pdf_path'] = $this->uploadFile($file);
        }

        $device = Device::create($attributes);

        return redirect('/devices/' . $device->id)->with('success', 'The device has been added!');
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Device $device)
    {
        $categories = Category::all();
        $photos = Photo::query()->where('device_id', '=', $device->id)->get();

        return view('pages.devices.edit', compact('device', 'categories', 'photos'));
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Device $device)
    {
        $attributes = $this->validateDevice($device);

        $attributes['edited_by_id'] = $request->user()->id;
        $attributes['updated_at'] = time();

        if (isset($attributes['pdf_path'])) {
            $file = $request->file('pdf_path');
            $attributes['pdf_name'] = $file->getClientOriginalName();
            $attributes['pdf_path'] = $this->uploadFile($file);
        }

        $device->update($attributes);

        return redirect('/devices/' . $device->id)->with('success', 'The device \'' . $device->name . '\' has been updated!');
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Device $device)
    {
        $photos = Photo::query()->where('device_id', '=', $device->id)->get();

        foreach ($photos as $photo) {
            Storage::delete($photo->photo_path);
        }

        if (isset($device->pdf_path)) {
            Storage::delete($device->pdf_path);
        }

        $device->delete();

        return redirect('/?category=' . $device->category_id)->with('success', 'The device \'' . $device->name . '\' has been deleted!');
    }

    /**
     * @return array
     */
    protected function validateDevice(?Device $device = null)
    {
        $device ??= new Device();

        return request()->validate([
            'name' => ['required', 'max:30', Rule::unique('devices', 'name')->ignore($device->id)],
            'pdf_path' => ['nullable', 'file'],
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
            return $file->store('pdf');
        } else {
            throw ValidationException::withMessages(['pdf_path' => 'The file must ba a PDF.']);
        }
    }
}
