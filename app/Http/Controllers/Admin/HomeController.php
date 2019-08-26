<?php

namespace App\Http\Controllers\Admin;

use App\CKEditor;
use App\Http\Controllers\AdminController;
use App\Page;
use Illuminate\Support\Facades\Auth;
use Zofe\Rapyd\DataEdit\DataEdit;

class HomeController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Support\Facades\Redirect|\Illuminate\Support\Facades\View|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            throw new \Exception('Bad request', 503);
        }

        $edit = DataEdit::source(new Page);
        $edit->attr('enctype', 'multipart/form-data');

        $edit->add('description', 'Description', '\\' . CKEditor::class);
        $edit->add('page_gallery', '', 'auto');

        return $edit->view('admin.forms.home', [
            'edit' => $edit,
            'title' => 'Edit home page',
            'nav' => $this->nav,
            'gallery' => $edit->model->getGallery(),
        ]);
    }
}
