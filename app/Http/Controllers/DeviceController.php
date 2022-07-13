<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    public function index()
    {
        return view('devices.index', ['devices' => Device::query()->orderBy('name')->paginate(5)]);
    }

    public function show(Device $device)
    {
        return view('devices.show', ['device' => $device, 'categories' => Category::all()]);
    }

    public function create()
    {
        return view('devices.create', ['categories' => Category::all()]);
    }

    public function store()
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        $attributes['created_by_id'] = 1;//request()->user()->id();

        $device = Device::create($attributes);

        return redirect('/devices/' . $device->id)->with('success', 'The device has been added!');
    }

    public function edit(Device $device)
    {
        return view('devices.edit', ['device' => $device, 'categories' => Category::all()]);
    }

    public function update(Device $device)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);

        $attributes['edited_by_id'] = 1;//request()->user()->id();

        $device->update($attributes);

        return redirect('/devices')->with('success', 'The device \'' . $device->name . '\' has been updated!');
    }

    public function destroy(Device $device)
    {
        $name = $device->name;

        $device->delete();

        return redirect('/devices')->with('success', 'The device \'' . $name . '\' has been deleted!');
    }
}
