@extends('application')

@section('content')

    <div class="row">

        <div class="col-sm-8 blog-main">
            @foreach($posts as $post)
                <h2>{{ $post->name }}</h2>
                <p>{{ $post->content }}</p>
            @endforeach
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