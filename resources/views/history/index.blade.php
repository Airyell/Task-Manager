@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User Activity History</h2>

    @if($activities->isEmpty())
        <p>No activity found.</p>
    @else
        <ul class="list-group">
            @foreach($activities as $activity)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        <strong>{{ $activity->action }}</strong> on {{ $activity->model_name }} at {{ $activity->created_at->format('Y-m-d H:i:s') }}
                    </span>
                    <form action="{{ route('history.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Delete this activity permanently?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
