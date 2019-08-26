<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    protected $nav = [
        ['CONTENTS', ['admin', 'moderator'], [
            ['Home', 'admin.home', 'show=1', ['admin']],
            ['Anketa &laquoA&raquo;', 'admin.anketa-content', ['litera' => 'a', 'show=2'], null, ['moderator' => 'moderatorA@example.com']],
            ['Anketa &laquoB&raquo;', 'admin.anketa-content', ['litera' => 'b', 'show=3'], null, ['moderator' => 'moderatorB@example.com']],
        ]],
        ['ANKETA', ['admin', 'moderator'], [
            ['List', 'admin.anketa'],
        ]],
    ];

    public function index()
    {
        return view('admin.index', [
            'nav' => $this->nav,
        ]);
    }
}
