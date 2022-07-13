<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('devices.index', ['devices' => Device::query()->orderBy('name')->paginate(5)]);
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Device $device)
    {
        return view('devices.show', ['device' => $device, 'categories' => Category::all()]);
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
        $attributes = array_merge($this->validateDevice(), [
            'created_by_id' => 1//request()->user()->id();
        ]);

        if(isset($attributes['pdf_path'])) {
            $attributes['pdf_path'] = request()->file('pdf_path')->store('pdf');
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
        return view('devices.edit', ['device' => $device, 'categories' => Category::all()]);
    }

    /**
     * @param Device $device
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Device $device)
    {
        $attributes = array_merge($this->validateDevice(), [
            'edited_by_id' => 1//request()->user()->id();
        ]);

        if (isset($attributes['pdf_path'])) {
            $attributes['pdf_path'] = request()->file('pdf_path')->store('pdf');
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

    protected function validateDevice() {
        return request()->validate([
            'name' => 'required',
            'pdf_path' => 'image',
            'description' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

    }
}
