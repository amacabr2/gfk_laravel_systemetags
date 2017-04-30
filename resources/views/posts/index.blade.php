@extends('application')

@section('content')

    <h1>Articles</h1>

    @foreach($posts as $post)

        <h2>{{ $post->name }}</h2>

        <p>{{ $post->content }}</p>

    @endforeach

@stop