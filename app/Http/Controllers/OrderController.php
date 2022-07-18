<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', ['devices' => Device::query()->orderBy('order')->get()]);
    }

    public function store()
    {
        foreach (request()->inDevices as $inDevice){
            Device::query()->where('id', '=', $inDevice['id'])->update(['order' => $inDevice["order"]]);
        }

        Session::put('success', 'The order has been saved');
        return ['success' => true];
    }
}
