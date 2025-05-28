@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">🕘 Activity History</h2>

    @if($activities->isEmpty())
        <div class="text-center text-gray-500">No activities found.</div>
    @else
        <ul class="space-y-4">
            @foreach ($activities as $activity)
                <li class="p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-gray-700 font-medium">
                            {{ $activity->description }}
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ $activity->created_at->format('M d, Y - h:i A') }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-400">
                        Action: <span class="italic">{{ $activity->action }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
