@extends('layouts.app')

@section('content')
<div class="py-8 px-4 max-w-4xl mx-auto">
    <div class="bg-[#fdf1e5] shadow-md rounded-2xl p-6">
        <h2 class="text-2xl font-bold text-center text-[#0b2c48] flex items-center justify-center gap-2 mb-6">
            <i class="bi bi-clock-history text-[#0b2c48] text-3xl"></i> Activity History
        </h2>

        @if($activities->isEmpty())
            <div class="text-center text-gray-500 py-12">
                <i class="fas fa-box-open text-4xl mb-4 text-[#0b2c48]"></i>
                <p class="text-lg">No recent activity found.</p>
            </div>
        @else
            <ul class="space-y-3">
                @foreach($activities as $activity)
                    <li class="flex justify-between items-start bg-[#fff8f0] p-4 rounded-xl">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $activity->action }}</p>
                            <p class="text-sm text-gray-500">on {{ $activity->model_name }}</p>
                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                <i class="bi bi-calendar-event"></i>
                                {{ $activity->created_at->timezone('Asia/Manila')->format('M d, Y - h:i A') }}
                            </p>
                        </div>
                        <form action="{{ route('history.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('Delete this activity permanently?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-[#ff914d] hover:bg-orange-600 text-white rounded-full p-2 transition">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
