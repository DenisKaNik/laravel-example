@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{!! $title !!}</h3>
                    </div>

                    <div class="panel-body">

                        @if (isset($show))

                            @if ($show->message != '')
                                {!! $show->open !!}
                            @endif

                            <div class="btn-group-vertical">
                                <a href="{{ route('admin.anketa') }}" class="btn btn-info">Next anketa list</a>
                            </div>

                            <div class="box-body">
                                <div class="rpd-dataform">

                                    @if ($show->message != '')
                                        <div class="alert alert-danger">{!! $show->message !!}</div>

                                        @include('rapyd::toolbar', array('buttons_left'=>$show->button_container['BL'], 'buttons_right'=>$show->button_container['BR'] ))
                                    @endif

                                    @if ($show->message == '')
                                        @each('rapyd::dataform.field', $show->fields, 'field')
                                    @endif

                                </div>
                            </div>

                            @if ($show->message != '')
                                {!! $show->close !!}
                            @endif

                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection