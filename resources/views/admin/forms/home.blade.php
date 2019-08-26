@extends('admin.form')

@section('content_header')
<h1>{!! $title !!}</h1>
@endsection

@section('form_bottom')
    @include('admin.gallery', ['gallery' => $gallery])
@endsection