@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Content</h3>
                    </div>

                    <div class="panel-body">

                        @if (isset($edit))
                            {!! $edit->open !!}

                            <div class="box-body">
                                <div class="rpd-dataform">
                                    @include('rapyd::toolbar', array('label'=>$edit->label, 'buttons_right'=>$edit->button_container['TR']))

                                    @if ($edit->message != '')
                                        <div class="alert alert-success">{!! $edit->message !!}</div>
                                    @endif

                                    @if ($edit->message == '')
                                        @each('rapyd::dataform.field', $edit->fields, 'field')
                                    @endif

                                    @yield('form_bottom')

                                    @include('rapyd::toolbar', array('buttons_left'=>$edit->button_container['BL'], 'buttons_right'=>$edit->button_container['BR'] ))
                                </div>
                            </div>

                            {!! $edit->close !!}
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection