@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    <a href="{{ route('admin.users.index') }}" class="me-2">
                        Indietro
                    </a>
                    <a class="ms-auto" href="{{ route('admin.users.edit', $user->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h4>{{ $user->name }}</h4>
                            <h5>{{ $user->email }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection