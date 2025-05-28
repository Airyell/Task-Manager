@extends('layouts.app')
&nbsp;
&nbsp;

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
&nbsp;
&nbsp;

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
&nbsp;
&nbsp;

                @if(config('Task-Manager.profile.avatar') !== false)
                <div class="card-body border-bottom">
                    <div class="user-profile-image">
                        <img src="{{ url($user->image) }}" alt="User Image">
                    </div>
                </div>
                @endif
&nbsp;
&nbsp;

                <div class="card-header">
                    <h5 class="float-left mb-0 mt-1 w-100 text-center">
                        <span class="text-info">{{ $user->email }}</span> <small class="text-muted font-italic">(Private)</small>
                    </h5>
                </div>
&nbsp;
&nbsp;

                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Name</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->name }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Job</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['job'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Company</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['company'] ?? '' }}</span>
                        </div>
                    </div>
                </div>
&nbsp;
&nbsp;

                @if(config('Task-Manager.profile.contact') !== false)
                <div class="card-header border-top">
                    <h5 class="float-left mb-0 mt-1">Contact</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Phone no.</div>
                        <div class="col-sm-6 field-bg">
                            @foreach($user->profile['phones'] ?? [] as $phone)
                                <div class="row">
                                    <span class="text-muted">{{ '+'.$phone[0].' '.$phone[1] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Mobile no.</div>
                        <div class="col-sm-6 field-bg">
                            @foreach($user->profile['mobiles'] ?? [] as $mobile)
                                <div class="row">
                                    <span class="text-muted">{{ '+'.$mobile[0].' '.$mobile[1] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Email</div>
                        <div class="col-sm-6 field-bg">
                            @foreach($user->profile['emails'] ?? [] as $email)
                                <div class="row">
                                    <span class="text-muted">{{ $email }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
&nbsp;
&nbsp;

                @if(config('Task-Manager.profile.address') !== false)
                <div class="card-header border-top">
                    <h5 class="float-left mb-0 mt-1">Address</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Country</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['country'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Town / City</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['city'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Street / Road</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['road'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Building</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['building'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Office</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['office'] ?? '' }}</span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6 text-sm-right">Extra Details</div>
                        <div class="col-sm-6 field-bg">
                            <span class="text-muted">{{ $user->profile['extra_details'] ?? '' }}</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <!-- /User Profile -->
        </div>
    </div>
</div>
@endsection