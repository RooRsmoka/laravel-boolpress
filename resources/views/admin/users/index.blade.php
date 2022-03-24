@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex">
                    Lista degli utenti
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="ms-auto">
                                <a class="me-2" href="{{ route('admin.users.show', $user->id) }}" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a class="text-secondary" href="{{ route('admin.users.edit', $user->id) }}" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection