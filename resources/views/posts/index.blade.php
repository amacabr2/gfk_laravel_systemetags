@extends('application')

@section('content')

    @if(Session::has('success'))
        <p class="alert alert-success">{{ Session::get('success') }}</p>
    @endif

    <div class="row">

        <div class="col-sm-8">
            @include('posts.form', ['post' => new \App\Post()])
        </div>

        <div class="col-sm-3 offset-sm-1 ">
            <h2>Nuage de tags</h2>
            @foreach($tags as $tag)
                <a style="font-size: {{ 1 + round($tag->post_count / $max, 2) }}rem" href="{{ route('posts.tag', ['slug' => $tag->slug]) }}">{{ $tag->name }}</a>
            @endforeach
        </div>

    </div>

    <hr>

    <div class="row">

        <div class="col-sm-8">

            @foreach($posts as $post)
                <h2>{{ $post->name }}</h2>
                <p>
                    @foreach($post->tags as $tag)
                        <a href="{{ route('posts.tag', ['slug' => $tag->slug]) }}" class="badge badge-default">{{ $tag->name }}</a>
                    @endforeach
                </p>
                <p>{{ $post->content }}</p>
                <p><a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Editer</a></p>
            @endforeach

            <div class="navigation">
                {{ $posts->links('vendor.pagination.bootstrap-4') }}
            </div>

        </div>

        <div class="col-sm-3 offset-sm-1 ">
            <div class="well">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid autem earum eveniet illo iusto,
                    magnam, necessitatibus officiis porro possimus quidem recusandae sapiente sint! Ad at ducimus id
                    placeat similique voluptatum.
                </p>
            </div>
        </div>

    </div>

@stop