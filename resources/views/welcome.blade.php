@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Welcome to our Laravel application. Explore our services and discover what we have to offer.')
@section('keywords', 'home, welcome, laravel, php, web application, services')

@section('content')
    <h1>Welcome</h1>
    <p>This application uses the left menu for navigation. The <a href="{{ url('/') }}">About</a> page shows an embedded preview of your GitHub Pages site.</p>
@endsection