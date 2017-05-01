<h2>Créer un nouvelle article</h2>

@if($post->id)
    <form action="{{ route('posts.update', $post) }}" method="post">
        <input type="hidden" name="_method" value="put">
@else
    <form action="{{ route('posts.store') }}" method="post">
@endif

    {{ csrf_field() }}

    <div class="form-group">
        <input type="text" class="form-control" name="name" value="{{ old('name', $post->name) }}" placeholder="Titre de l'article">
    </div>

    <div class="form-group">
        <textarea class="form-control" name="content" placeholder="Contenu de l'article">{{ old('content', $post->content) }}</textarea>
    </div>

    <div class="form-group">
        <input data-url="{{ route('tags.index') }}" type="text" id="tokenfield" class="form-control" name="tags" value="{{ old('tags', $post->tagsList) }}" placeholder="Tags de l'article (mettez une virgule après chaque tag)">
    </div>

    <button class="btn btn-primary">Envoyer</button>

</form>