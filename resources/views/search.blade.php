@extends('layouts.app')

@section('title', 'Search Results')
@section('description', 'Search results for your query')
@section('keywords', 'search, results, query, information')

@section('content')
<div style="padding: 20px; text-align: center;">
    <h1>Search Results</h1>
    <p>You searched for: <strong>{{ $query }}</strong></p>
    <p>No results found. This is a placeholder page for search functionality.</p>
</div>
@endsection