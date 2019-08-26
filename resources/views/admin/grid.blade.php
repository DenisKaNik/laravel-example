@extends('layouts.admin')

@section('title')
    Laravel example - {{ $title }}
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>

                <div class="panel-body">

                    @if (isset($filter))
                        {!! $filter !!}
                    @else
                    @endif

                    @if (isset($grid))
                        {!! $grid !!}
                    @else
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
