<h1>User Profile</h1>
<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<p>Image: <img src="{{ asset($user->image) }}" alt="User Image"></p>
@if (isset($user->profile['bio']))
    <p>Bio: {{ $user->profile['bio'] }}</p>
@endif
<a href="{{ route('profile.edit') }}">Edit Profile</a>