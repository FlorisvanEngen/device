<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|void
     */
    public function index(Request $request)
    {
        try {
            if ($request->category) {
                $currentCategory = Category::with('devices')->find($request->category);
            } else {
                $currentCategory = Category::with('devices')->first();
            }

            $categories = Category::get();
            return view('pages.devices.order.index', compact('categories', 'currentCategory'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            abort(500);
        }
    }

    /**
     * @param $category
     * @return mixed
     */
    public function show($category)
    {
        try {
            return [
                'success' => true,
                'device' => Device::without('category')->where('category_id', $category)->orderBy('order')->get(['id', 'order'])
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errorMsg' => $e->getMessage()];
        }
    }

    /**
     * @param Request $request
     * @return array|bool[]
     */
    public function store(Request $request)
    {
        try {
            foreach ($request->inDevices as $inDevice) {
                Device::find($inDevice['id'])->update(['order' => $inDevice["order"]]);
            }

            Session::flash('success', 'The new device order has been saved!');
            return ['success' => true];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return ['success' => false, 'errorMsg' => $e->getMessage()];
        }
    }
}
