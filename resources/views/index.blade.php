@extends('layouts.base_layout')

@section('title', 'Inicio')

@section('index_body_content')
    @yield('normal_content')
    @yield('form')
    @yield('list')
@endsection


