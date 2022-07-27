<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
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
        $devices = Device::orderBy('order')->filter(compact('currentCategory'))->get();

        return view('pages.devices.order.index', compact('devices', 'categories', 'currentCategory'));
    }

    /**
     * @return bool[]
     */
    public function store(Request $request)
    {
        try {
            foreach ($request->inDevices as $inDevice) {
                Device::query()->where('id', '=', $inDevice['id'])->update(['order' => $inDevice["order"]]);
            }

            Session::flash('success', 'The new device order has been saved!');
            return ['success' => true];
        } catch (Exception $e) {
            $errorMsg = $e;
        }
        return ['success' => false, 'errorMsg' => $errorMsg];
    }

    /**
     * @param Category $category
     * @return mixed
     */
    public function show(Category $category)
    {
        return Device::orderBy('order')->where('category_id', $category->id)->get(['id', 'order']);
    }
}
