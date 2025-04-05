@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Мой профиль</div>

                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Имя</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" value="{{ $user->full_name }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="avatar" class="col-md-4 col-form-label text-md-end">Аватар</label>
                        <div class="col-md-6">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail" style="max-width: 100px;">
                            @else
                                <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="img-thumbnail" style="max-width: 100px;">
                            @endif
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                Редактировать профиль
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 