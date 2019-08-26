<?php

namespace App\Http\Controllers;

use App\Anketa;
use App\Http\Requests\AnketaPost;
use App\Jobs\SendEmail;
use App\Page;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AnketaController extends Controller
{
    protected $arrContentId = [
        'a' => 2,
        'b' => 3,
    ];

    protected $arrEmail = [
        'a' => 'moderatorA@example.com',
        'b' => 'moderatorB@example.com',
    ];

    public function index($litera)
    {
        if (isset($this->arrContentId[$litera])) {
            $content = Page::whereId($this->arrContentId[$litera])->firstOrFail();
        }
        else {
            throw new NotFoundHttpException();
        }

        return view('anketa', compact('litera', 'content'));
    }

    public function post(AnketaPost $request, $litera)
    {
        if (!$request->ajax()) {
            return response()->json(['message' => 'Not Found!'], 404);
        }

        $request->validated();

        (new Anketa())
            ->setAttribute('type', $litera)
            ->fill($request->input())
            ->save();

        dispatch(new SendEmail([
            'to' => [$request->get('email')],
            'subject' => 'Регистрация на мероприятие',
            'view' => 'user',
            'name' => $request->get('first_name'),
        ]));

        if (isset($this->arrEmail[$litera])) {
            dispatch(new SendEmail([
                'to' => [$this->arrEmail[$litera]],
                'subject' => 'Новая заявка на регистрацию с сайта',
                'view' => 'moderator',
                'data' => $request->input(),
            ]));
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
