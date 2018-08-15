@extends('layouts.default')

@section('title', 'Resources')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <div id="app">
        <p>This is my body content.</p>
        @include('pages.my-example')
    </div>
@endsection