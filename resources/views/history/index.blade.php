@extends('layouts.app')

@section('content')
<!-- Header outside container -->
<h2 class="text-2xl font-extrabold mb-4 text-gray-800 text-center">Activity History</h2>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
    @if($activities->isEmpty())
        <div class="text-center text-gray-500">No activities found.</div>
    @else
        <ul class="space-y-4">
            @foreach ($activities as $activity)
                <li class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition flex justify-between items-start">
                    <!-- Left: Text content -->
                    <div class="flex-1">
                        <!-- Action on top, extra bold, bigger -->
                        <p class="font-extrabold text-black mb-2 text-2xl">
                            {{ $activity->action }}
                        </p>
                        <!-- Description -->
                        <p class="text-gray-700 mb-1">
                            {{ $activity->description }}
                        </p>
                        <!-- Timestamp smaller -->
                        <p class="text-xs text-gray-500">
                            {{ $activity->created_at->timezone('Asia/Manila')->format('M d, Y - h:i A') }}
                        </p>
                    </div>

                    <!-- Right: Delete Button aligned top-right of the content -->
                    <div class="ml-4">
                        <form action="{{ route('history.destroy', $activity->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this activity?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" title="Delete Activity">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
