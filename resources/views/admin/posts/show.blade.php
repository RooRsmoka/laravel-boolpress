@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <a href="{{ route('admin.posts.index') }}" class="me-2">Indietro</a>
                    {{ $post->title }}
                    <a class="ms-auto" href="{{ route('admin.posts.edit', $post->slug) }}">Modifica</a>
                </div>
                <div class="card-body">
                    <p class="lead">
                        {!! $post->content !!}
                    </p>
                    <div class="my-3">
                        Data creazione: {{ $post->created_at }}
                        <br>
                        Data ultima modifica: {{ $post->updated_at }}
                        <br>
                        Slug: {{ $post->slug }}
                    </div>
                    <div class="my-3">
                        Utente: {{ $post->user->name }}
                        <br>
                        Email: {{ $post->user->email }}
                    </div>
                    @if ($post->category !== null)
                    <div class="my-3">
                        Categoria: {{ $post->category->name }}
                        <br>
                        Descrizione: {{ $post->category->description }}
                    </div>
                    @endif

                    @if ($post->tags !== null)
                    <div class="my-3">
                        tags:
                        @foreach ($post->tags as $tag)
                        <span class="bg-light">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection