@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    Lista dei post
                    <a class="ms-auto" href="{{ route('admin.posts.create') }}">Aggiungi...</a>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($posts as $post)
                        <li class="list-group-item d-flex align-items-center">
                            <div>
                                {{ $post->title }}
                                <br>
                                @php
                                    $dateFormat = 'd/m/Y H:i'
                                @endphp
                                <small class="fst-italic">{{ $post->created_at->format($dateFormat) }} - {{ $post->user->name }} - {{ isset($post->category) ? $post->category->name : "senza categoria" }}</small>
                            </div>
                            <a class="ms-auto" href="{{ route('admin.posts.show', $post->slug) }}">Mostra</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection