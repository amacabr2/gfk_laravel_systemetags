@extends('application')

@section('content')

    <div class="row">

        <div class="col-sm-8">
            @include('posts.form', ['post' => new \App\Post()])
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
            @endforeach
            {{ $posts->links() }}
        </div>
    </div>

@stop