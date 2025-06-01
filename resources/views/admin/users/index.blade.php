@extends('layouts.admin') {{-- Or whatever your admin layout file is --}}

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Manage Users</h1>

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">User List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- Added Bootstrap classes for table styling and alignment --}}
                <table class="table table-bordered table-hover" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            {{-- Text alignment classes for table headers --}}
                            <th class="text-start">ID</th>
                            <th class="text-start">Name</th>
                            <th class="text-start">Username</th>
                            <th class="text-start">Email</th>
                            <th class="text-start">Role</th>
                            <th class="text-center">Actions</th> {{-- Centered for better action button alignment --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            {{-- Text alignment classes for table data cells --}}
                            <td class="text-start">{{ $user->id }}</td>
                            <td class="text-start">{{ $user->name }}</td>
                            <td class="text-start">{{ $user->username }}</td>
                            <td class="text-start">{{ $user->email }}</td>
                            {{-- Displaying 'user' or the actual role, capitalized --}}
                            <td class="text-start">{{ ucfirst($user->role ?? 'user') }}</td>
                            <td class="text-center"> {{-- Centered for action buttons --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm mb-1">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{-- You might want to add scripts for data tables here if using --}}
    {{-- Example for a simple DataTables initialization --}}
    {{-- Ensure you have DataTables CSS and JS included in your layout if uncommenting --}}
    {{-- <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true
            });
        });
    </script> --}}
@endpush