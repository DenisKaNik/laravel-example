@extends('layouts.app')

@section('content')
    <div class="col-lg-8 col-md-10 mx-auto">
        <h2 class="post-title">Welcome to Laravel example WebSite</h2>

        @include('partials.content', ['html' => $home])

    </div>
@endsection