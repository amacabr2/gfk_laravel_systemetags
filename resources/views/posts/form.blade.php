<h2>Créer un nouvelle article</h2>

<form action="{{ route('posts.store') }}" method="post">

    {{ csrf_field() }}

    <div class="form-group">
        <input type="text" class="form-control" name="name" value="{{ old('name', $post->name) }}" placeholder="Titre de l'article">
    </div>

    <div class="form-group">
        <textarea class="form-control" name="content" placeholder="Contenu de l'article">{{ old('content', $post->content) }}</textarea>
    </div>

    <div class="form-group">
        <input data-url="{{ route('tags.index') }}" type="text" id="tokenfield" class="form-control" name="tags" value="{{ old('tags') }}" placeholder="Tags de l'article">
    </div>

    <button class="btn btn-primary">Envoyer</button>

</form>