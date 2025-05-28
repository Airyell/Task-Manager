@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow border-0 rounded-4" style="background-color: #fdf1e5;">
        <div class="card-body">
            <h2 class="mb-4 fw-bold text-dark">
                <i class="bi bi-clock-history me-2" style="color: #0b2c48;"></i> Activity History
            </h2>

            @if($activities->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-box-open fa-3x mb-3" style="color: #0b2c48;"></i>
                    <p class="fs-5">No recent activity found.</p>
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($activities as $activity)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3" style="background-color: #fff8f0; border: none; border-radius: 10px; margin-bottom: 8px;">
                            <div>
                                <span class="fw-semibold text-dark">{{ $activity->action }}</span>
                                <span class="text-muted">on {{ $activity->model_name }}</span>
                                <div class="small text-secondary mt-1">
                                    <i class="bi bi-calendar-event me-1"></i>{{ $activity->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                            <form action="{{ route('history.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Delete this activity permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background-color: #ff914d; color: white; border-radius: 20px;">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
