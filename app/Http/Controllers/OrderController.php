<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index', ['devices' => Device::query()->orderBy('order')->get()]);
    }

    public function store()
    {
        dd('hit!');
    }
}
