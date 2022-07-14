<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use App\Models\Photo;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DeviceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('devices.index', [
            'devices' => Device::query()->orderBy('order')->filter(request(['category']))->paginate(20),
            'categories' => Category::all(),
            'currentCategory' => Category::firstWhere('id', request('category'))
        ]);
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Device $device)
    {
        return view('devices.show', [
            'device' => $device,
            'categories' => Category::all(),
            'photos' => Photo::query()->where('device_id', '=', $device->id)->get()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('devices.create', ['categories' => Category::all()]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = $this->validateDevice();

        $attributes['created_by_id'] = request()->user()->id;

        if (isset($attributes['pdf_path'])) {
            $attributes['pdf_path'] = $this->uploadFile(request()->file('pdf_path'));
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
        return view('devices.edit', [
            'device' => $device,
            'categories' => Category::all(),
            'photos' => Photo::query()->where('device_id', '=', $device->id)->get()
        ]);
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Device $device)
    {
        $attributes = $this->validateDevice();

        $attributes['edited_by_id'] = request()->user()->id;
        $attributes['updated_at'] = time();

        if (isset($attributes['pdf_path'])) {
            $attributes['pdf_path'] = $this->uploadFile(request()->file('pdf_path'));
        }

        $device->update($attributes);

        return redirect('/devices')->with('success', 'The device \'' . $device->name . '\' has been updated!');
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect('/devices')->with('success', 'The device \'' . $device->name . '\' has been deleted!');
    }

    /**
     * @return array
     */
    protected function validateDevice()
    {
        return request()->validate([
            'name' => ['required'],
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
