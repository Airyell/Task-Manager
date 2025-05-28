@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- User Profile -->
            <form class="card user-profile" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h4 class="mb-0 mt-2">User Profile</h4>
                </div>

                <div class="card-body pb-0 pt-0">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-0 mt-3">
                            <h4 class="font-weight-bold">Profile update failed!</h4>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                @if(config('Task-Manager.profile.avatar') !== false)
                <div class="card-body border-bottom">
                    <div class="user-profile-image">
                        <div class="user-profile-image--default">
                            <img src="{{ url($user->image) }}" alt="User Image">
                        </div>
                        <div class="user-profile-image--button">
                            <input type="file" name="image">
                            <div class="user-profile-image--button-label">Change</div>
                        </div>
                    </div>
                    @if(isset($user->profile['image']))
                    <div class="mt-2 text-center">
                        <button type="button" class="btn btn-light text-danger text-uppercase font-weight-bold btn-100" onclick="removeUserProfileImage()">
                            Remove
                        </button>
                    </div>
                    @endif
                </div>
                @endif

                <div class="card-header">
                    <h5 class="float-left mb-0 mt-1 w-100 text-center">
                        <span class="text-info">{{ $user->email }}</span> <small class="text-muted font-italic">(Private)</small>
                    </h5>
                </div>

                <div class="card-body">
                    <div class="form-group row pt-3">
                        <label for="name" class="col-sm-4 col-form-label text-sm-right">Name <small class="text-danger font-italic">(Required)</small></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="job" class="col-sm-4 col-form-label text-sm-right">Job</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="job" name="job" value="{{ old('job', $user->profile['job'] ?? '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="company" class="col-sm-4 col-form-label text-sm-right">Company</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $user->profile['company'] ?? '') }}">
                        </div>
                    </div>
                </div>

                @if(config('Task-Manager.profile.contact') !== false)
                <div class="card-header border-top">
                    <h5 class="float-left mb-0 mt-1">Contact</h5>
                </div>
                <div class="card-body">
                    <!-- Phones -->
                    <div class="dynamic-form-fields">
                        @foreach(old('phones', $user->profile['phones'] ?? [['', '']]) as $key => $phone)
                        <div class="form-group row dynamic-form-field">
                            <label class="col-sm-4 col-form-label text-sm-right">{{ $key == 0 ? 'Phone no.' : '' }}</label>
                            <div class="col-auto">
                                <input type="text" class="form-control" style="width: 75px;" name="phones[{{ $key }}][0]" value="{{ $phone[0] }}">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="phones[{{ $key }}][1]" value="{{ $phone[1] }}">
                            </div>
                            <div class="col-auto pl-0">
                                <button type="button" class="btn btn-danger remove-field-button" onclick="deleteField(event)">-</button>
                                @if($key == 0)
                                <button type="button" class="btn btn-success add-new-field-button" onclick="addNewField(event, 'phones', true)">+</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Emails -->
                    <div class="dynamic-form-fields">
                        @foreach(old('emails', $user->profile['emails'] ?? ['']) as $key => $email)
                        <div class="form-group row dynamic-form-field">
                            <label class="col-sm-4 col-form-label text-sm-right">{{ $key == 0 ? 'Email' : '' }}</label>
                            <div class="col">
                                <input type="text" class="form-control" name="emails[{{ $key }}]" value="{{ $email }}">
                            </div>
                            <div class="col-auto pl-0">
                                <button type="button" class="btn btn-danger remove-field-button" onclick="deleteField(event)">-</button>
                                @if($key == 0)
                                <button type="button" class="btn btn-success add-new-field-button" onclick="addNewField(event, 'emails')">+</button>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(config('Task-Manager.profile.address') !== false)
                <div class="card-header border-top">
                    <h5 class="float-left mb-0 mt-1">Address</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-sm-right">Country</label>
                        <div class="col">
                            <select class="form-control" name="country">
                                <option value=""></option>
                                <!-- Add country options here -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-sm-right">Town / City</label>
                        <div class="col">
                            <input type="text" class="form-control" name="city" value="{{ old('city', $user->profile['city'] ?? '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-sm-right">Street / Road</label>
                        <div class="col">
                            <input type="text" class="form-control" name="road" value="{{ old('road', $user->profile['road'] ?? '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-sm-right">Building</label>
                        <div class="col">
                            <input type="text" class="form-control" name="building" value="{{ old('building', $user->profile['building'] ?? '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-sm-right">Office</label>
                        <div class="col">
                            <input type="text" class="form-control" name="office" value="{{ old('office', $user->profile['office'] ?? '') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label text-sm-right">Extra Details</label>
                        <div class="col">
                            <input type="text" class="form-control" name="extra_details" value="{{ old('extra_details', $user->profile['extra_details'] ?? '') }}">
                        </div>
                    </div>
                </div>
                @endif

                <div class="card-footer">
                    <div class="btn-group float-right text-uppercase" role="group">
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary btn-100">Cancel</a>
                        <button type="button" class="btn btn-success btn-100 text-uppercase" onclick="submitForm(event)">Save</button>
                    </div>
                </div>
            </form>
            <!-- /User Profile -->

            @if(config('Task-Manager.profile.avatar') !== false)
            <!-- Remove User Profile Image -->
            <form id="remove-user-image-form" method="POST" action="{{ url('profile/image') }}">
                @csrf
                @method('DELETE')
            </form>
            <!-- /Remove User Profile Image -->
            @endif
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function submitForm(event) {
        let form = $(event.target).closest('form')[0];
        form.submit();
    }

    function addNewField(event, name, multiFields = false) {
        let parent = $(event.target).closest('.dynamic-form-fields');
        let fields = parent.find('.dynamic-form-field');
        let counter = fields.length;

        let content = multiFields ? 
            `<div class="form-group row dynamic-form-field">
                <label class="col-sm-4 col-form-label text-sm-right"></label>
                <div class="col-auto">
                    <input type="text" class="form-control" style="width: 75px;" name="${name}[${counter}][0]">
                </div>
                <div class="col">
                    <input type="text" class="form-control" name="${name}[${counter}][1]">
                </div>
                <div class="col-auto pl-0">
                    <button type="button" class="btn btn-danger remove-field-button" onclick="deleteField(event)">-</button>
                </div>
            </div>` :
            `<div class="form-group row dynamic-form-field">
                <label class="col-sm-4 col-form-label text-sm-right"></label>
                <div class="col">
                    <input type="text" class="form-control" name="${name}[${counter}]">
                </div>
                <div class="col-auto pl-0">
                    <button type="button" class="btn btn-danger remove-field-button" onclick="deleteField(event)">-</button>
                </div>
            </div>`;

        parent.append(content);
    }

    function deleteField(event) {
        $(event.target).closest('.dynamic-form-field').remove();
    }

    function removeUserProfileImage() {
        document.getElementById('remove-user-image-form').submit();
    }
</script>
@endsection
