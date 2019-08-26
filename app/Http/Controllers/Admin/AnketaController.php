<?php

namespace App\Http\Controllers\Admin;

use App\Anketa;
use App\CKEditor;
use App\Http\Controllers\AdminController;
use App\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Zofe\Rapyd\DataEdit\DataEdit;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\DataGrid\DataGrid;

class AnketaController extends AdminController
{
    protected $arrPermissionType = [
        'moderatorA@example.com' => 'a',
        'moderatorB@example.com' => 'b',
    ];

    protected $arrPermissionContent = [
        'moderatorA@example.com' => 2,
        'moderatorB@example.com' => 3,
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $_user = Auth::user();
        $_isAdmin = $_user->isAdmin();

        if ($_isAdmin) {
            $filter = DataFilter::source(new Anketa);
        }
        elseif (isset($this->arrPermissionType[$_user->email])) {
            $filter = DataFilter::source(
                (new Anketa)::whereType(
                    $this->arrPermissionType[$_user->email]
                )
            );
        }
        else {
            throw new \Exception('Bad request', 503);
        }

        $filter->add('first_name', 'First name', 'text');
        $filter->add('last_name', 'Last name', 'text');
        $filter->add('phone', 'Phone', 'text');
        $filter->add('email', 'Email', 'text');

        $filter->submit('Search');
        $filter->reset('Clear');

        $grid = DataGrid::source($filter);

        $grid->add('id', 'ID');
        $grid->add('first_name', 'First name');
        $grid->add('last_name', 'Last name');
        $grid->add('phone', 'Phone');
        $grid->add('email', 'Email');
        $grid->add('education', 'Education');

        if ($_isAdmin) {
            $grid->add('type', 'Type');
            $grid->add('ip', 'IP');
            $grid->add('get_url', 'URL');
        }

        $grid->add('created_at', 'Created');

        if ($_isAdmin) {
            $grid->edit(route('admin.anketa-show'), 'Actions', 'show|delete');
        }
        else {
            $grid->edit(route('admin.anketa-show'), 'Actions', 'show');
        }

        $grid->orderBy('created_at', 'desc');
        $grid->paginate(20);

        return view('admin.grid', [
            'grid' => $grid,
            'filter' => $filter,
            'nav' => $this->nav,
            'title' => 'Anketa list',
        ]);
    }

    /**
     * @return \Illuminate\Support\Facades\Redirect|\Illuminate\Support\Facades\View
     * @throws \Exception
     */
    public function show()
    {
        $_user = Auth::user();
        $_isAdmin = $_user->isAdmin();

        if (!$_isAdmin && empty($this->arrPermissionType[$_user->email])) {
            throw new \Exception('Bad request', 503);
        }

        $show = DataEdit::source(new Anketa);

        if (!$show->model) {
            throw new \Exception('Bad request', 503);
        }

        if (!$_isAdmin
            && isset($this->arrPermissionType[$_user->email])
            && $this->arrPermissionType[$_user->email] != $show->model->type
        ) {
            throw new \Exception('Bad request', 503);
        }

        if (!$_isAdmin && !request()->has('show')) {
            throw new \Exception('Bad request', 503);
        }

        $show->add('first_name', 'First name', 'text');
        $show->add('last_name', 'Last name', 'text');
        $show->add('phone', 'Phone', 'text');
        $show->add('email', 'Email', 'text');
        $show->add('education', 'Education', 'text');

        if ($_isAdmin) {
            $show->add('type', 'Type', 'text');
            $show->add('ip', 'IP', 'text');
            $show->add('get_url', 'URL', 'text');
        }

        $show->add('created_at', 'Created', 'text');

        return $show->view('admin.anketa', [
            'show' => $show,
            'nav' => $this->nav,
            'title' => 'Show anketa #' . $show->model->id .
                ($_isAdmin ? ' by type &laquo;'.ucfirst($show->model->type).'&raquo;' : ''),
        ]);
    }

    /**
     * @return \Illuminate\Support\Facades\Redirect|\Illuminate\Support\Facades\View
     * @throws \Exception
     */
    public function content($litera)
    {
        $_user = Auth::user();
        $_isAdmin = $_user->isAdmin();

        $edit = DataEdit::source(new Page);

        if (!$_isAdmin
            && isset($this->arrPermissionContent[$_user->email])
            && $this->arrPermissionContent[$_user->email] != $edit->model->id
        ) {
            throw new \Exception('Bad request', 503);
        }


        $edit->attr('enctype', 'multipart/form-data');

        $edit->add('description', 'Description', '\\' . CKEditor::class);
        $edit->add('page_gallery', '', 'auto');

        return $edit->view('admin.forms.home', [
            'edit' => $edit,
            'title' => 'Edit page: Anketa &laquo;'.ucfirst($litera).'&raquo;',
            'nav' => $this->nav,
            'gallery' => $edit->model->getGallery(),
        ]);
    }
}
