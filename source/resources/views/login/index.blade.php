@extends('layouts/index')

@section('content')
    @if (Auth::check())
        HALAMAN LOGIN BRO
    @else
        HALAMAN LOGIN BUKAN ADMIN
    @endif
@endsection

@section('script')
    <script>

    </script>
@endsection