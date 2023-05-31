@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Profile')
@section('content')
    <div class="card shadow mb-4 col-12">
        {{-- alert messages --}}
        @if (session('success'))
            <div class="col-12 col-sm-6 col-md-4 alert alert-info alert-dismissible fade show mt-1" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('warning'))
            <div class="col-12 col-sm-6 col-md-4 alert alert-warning alert-dismissible fade show mt-1" role="alert">
                <i class="fa-solid fa-triangle-exclamation"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('danger'))
            <div class="col-12 col-sm-6 col-md-4 alert alert-danger alert-dismissible fade show mt-1" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- alert messages end --}}
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-center">Profile
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img @if ($user->image != null) src="{{ asset('storage/admin_image/' . $user->image) }}"
                        @elseif ($user->gender == 'male')
                        src="{{ asset('images/default_profile.webp') }}"
                        @else
                        src="{{ asset('images/default_female.jpg') }}" @endif
                        alt="profile image" class="img-fluid object-fit-cover rounded-circle"
                        style="width:200px;height:200px">
                </div>
                <div class="col-md-6 table-responsive">
                    <table class="table table-striped mt-3">
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>:</td>
                                <td>{{ $user->role }}</td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td>:</td>
                                <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>{{ $user->address }}</td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{ $user->gender }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 text-center">
                    <a href="{{ route('adminProfile.edit') }}" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
