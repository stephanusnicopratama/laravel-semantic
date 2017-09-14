@extends('layouts/index')

@section('content')
    @if (Auth::check())
        HALAMAN LOGIN BRO
    @else
        HALAMAN LOGIN BERO
    @endif
@endsection
