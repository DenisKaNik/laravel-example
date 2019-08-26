<?php

namespace App\Http\Controllers;

use App\Page;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'home' => Page::whereId(1)->firstOrFail(),
        ]);
    }
}
