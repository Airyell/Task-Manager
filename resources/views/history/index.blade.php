@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Activity History</h2>

    @if($activities->isEmpty())
        <p>No activity found.</p>
    @else
        <ul class="list-group">
            @foreach($activities as $activity)
                <li class="list-group-item">
                    <strong>{{ $activity->action }}</strong> on {{ $activity->model_name }} at {{ $activity->created_at->format('Y-m-d H:i:s') }}
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection