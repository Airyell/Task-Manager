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
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Username</th> {{-- Added Username column --}}
                            <th>Email</th>
                            <th>Role</th> {{-- Changed from 'Role' to 'Role' --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td> {{-- Display Username --}}
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td> {{-- Display Role, capitalized --}}
                            <td>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td> {{-- Updated colspan --}}
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- You might want to add scripts for data tables here if using --}}
@push('scripts')
    {{-- Example for a simple DataTables initialization --}}
    {{-- <script>
        $(document).ready(function() {
            $('#usersTable').DataTable();
        });
    </script> --}}
@endpush