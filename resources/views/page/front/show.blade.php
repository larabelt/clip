@extends('ohio-core::layouts.front.main')

@section('meta-title', $page->meta_title)
@section('meta-description', $page->meta_description)
@section('meta-keywords', $page->meta_keywords)

@section('main')

    <div class="container">
        {{ $page->body }}
    </div>

@endsection