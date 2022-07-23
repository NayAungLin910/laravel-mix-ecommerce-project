@extends('layout.master')
@section('header-text', 'Profile')
@section('content')
    <div id="root"></div>
@endsection
@section('script')
    <script src="{{ mix('js/profile.js') }}"></script>
@endsection
