@extends('layouts.app')

@section('content')
<style>
    .user-profile {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .user-profile .card-header {
        background: #0f2d4e;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
    }

    .user-profile .card-body {
        padding: 1.5rem;
    }

    .field-label {
        font-weight: 600;
        color: #333;
        text-align: right;
    }

    .field-value {
        background-color: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
    }

    .alert-success {
        margin-top: 1rem;
    }

    @media (max-width: 576px) {
        .field-label {
            text-align: left;
            margin-bottom: 0.25rem;
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- User Profile -->
            <div class="card user-profile">
                <div class="card-header">
                    <h4 class="mb-0">User Profile</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light text-dark btn-sm text-uppercase">Edit</a>
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3" role="alert">
                        <strong>{{ session('status') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 field-label">Name</div>
                        <div class="col-sm-8 field-value">{{ $user->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 field-label">Email</div>
                        <div class="col-sm-8 field-value">{{ $user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 field-label">Username</div>
                        <div class="col-sm-8 field-value">{{ $user->username ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            <!-- /User Profile -->
        </div>
    </div>
</div>
@endsection
