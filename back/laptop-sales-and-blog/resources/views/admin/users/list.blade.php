@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Users')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Users
                <a href="{{ route('admin.createUserPage') }}" class="btn btn-sm btn-primary float-end">
                    <i class="fa-solid fa-user-plus"></i>
                    Create User
                </a>
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Table -->
            <div class="card shadow mb-4">
                {{-- alert messages --}}
                @if (session('success'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-info alert-dismissible fade show mt-1" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-warning alert-dismissible fade show mt-1"
                        role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('danger'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-danger alert-dismissible fade show mt-1"
                        role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('danger') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- alert messages end --}}
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $users->count() }} Accounts
                        <div class="float-end">
                            <form action="{{ route('admin.usersList') }}" method="GET">
                                @csrf

                                <div class="input-group">
                                    <input type="text" name="search" id="search" placeholder="Search..."
                                        value="{{ request('search') }}" class="form-control">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('admin.adminsList') }}">Admins</a> |
                            <a href="{{ route('admin.normalUsers') }}">Users</a>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    <div>
                        {{ $users->links() }}
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-nowrap">{{ $user->id }}</td>
                                        <td class="text-nowrap">{{ $user->name }}</td>
                                        <td class="text-nowrap">{{ $user->email }}</td>
                                        <td class="text-nowrap userRole">{{ $user->role }}</td>
                                        <td class="text-nowrap">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#userModal{{ $user->id }}" {{ $user->role == 'admin' ? 'disabled' : '' }}>
                                                <i class="fa-solid fa-circle-info"></i>
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <form class="userForm">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Account
                                                                    Details
                                                                </h1>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body table-responsive">
                                                                <table class="table table-striped mt-3">
                                                                    {{-- error --}}
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                Name
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td class="text-nowrap">
                                                                                {{ $user->name }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                Email
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td class="text-nowrap">
                                                                                {{ $user->email }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                Phone
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td class="text-nowrap">
                                                                                {{ $user->phone }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                Address
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td class="text-nowrap">
                                                                                <textarea class="form-control" disabled>{{ $user->address }}</textarea>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-nowrap">
                                                                                Gender
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td class="text-nowrap">
                                                                                {{ $user->gender }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-nowrap text-danger">
                                                                                <label for="role">Change Role</label>
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td>
                                                                                <input type="hidden" id="userId" value="{{ $user->id }}">
                                                                                <select id="role" class="form-control">
                                                                                    <option value="admin"
                                                                                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                                                        Admin</option>
                                                                                    <option value="user"
                                                                                        {{ $user->role == 'user' ? 'selected' : '' }}>
                                                                                        User</option>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.userForm').submit(function(e) {
                e.preventDefault();
                let modalDiv = $(this).closest('.modal');
                let role = modalDiv.find('#role').val();
                let userId = Number(modalDiv.find('#userId').val());

                // for change user role after response
                let row = $(this).closest('tr');
                let userRole = row.find('.userRole');

                $.ajax({
                    type: "get",
                    url: "{{ route('admin.changeRole') }}",
                    data: {
                        'role': role,
                        'userId': userId
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.message == 'success') {
                            $(`#userModal${userId}`).modal('hide');
                            alert('You changed a user\'s role successfully!');
                            userRole.text(role);
                        }
                    }
                });
            })
        })
    </script>
@endsection
