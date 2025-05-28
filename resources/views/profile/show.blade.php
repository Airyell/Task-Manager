@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- User Profile -->
            <div class="card user-profile">
                <div class="card-header">
                    <h4 class="float-left mb-0 mt-2">User Profile</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-100 float-right text-uppercase">Edit</a>
                </div>

                <div class="card-body pb-0 pt-0">
                    @if (session('status'))
                        <div class="alert alert-success mb-0 mt-3">
                            <strong>{{ session('status') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Name</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Email</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->email }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Username</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->username ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /User Profile -->
        </div>
    </div>
</div>
@endsection
