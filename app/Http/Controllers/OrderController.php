<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('order.index', ['devices' => Device::query()->orderBy('order')->get()]);
    }

    /**
     * @return bool[]
     */
    public function store()
    {
        foreach (request()->inDevices as $inDevice){
            Device::query()->where('id', '=', $inDevice['id'])->update(['order' => $inDevice["order"]]);
        }

        Session::flash('success', 'The new device order has been saved!');
        return ['success' => true];
    }
}
