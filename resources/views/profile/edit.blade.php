@extends('layouts.app')

@section('content')
<div class="container vh-90 d-flex justify-content-center align-items-center">
    <div class="col-md-8">

        <form class="card w-100" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="card-header text-center">
                <h4 class="mb-0 mt-2">Edit Profile</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger mb-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group row">
                    <label for="name" class="col-sm-4 col-form-label text-sm-right">Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label text-sm-right">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username ?? '') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-4 col-form-label text-sm-right">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <label for="current_password" class="col-sm-4 col-form-label text-sm-right">Current Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="current_password" name="current_password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_password" class="col-sm-4 col-form-label text-sm-right">New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="new_password" name="new_password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_password_confirmation" class="col-sm-4 col-form-label text-sm-right">Confirm Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                    </div>
                </div>
            </div>

            <div class="card-footer text-right">
                <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </form>

    </div>
</div>
@endsection
