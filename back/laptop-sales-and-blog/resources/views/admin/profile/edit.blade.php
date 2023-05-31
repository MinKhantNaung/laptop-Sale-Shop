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
            <h6 class="m-0 font-weight-bold text-primary text-center">Profile Edit
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('adminProfile.update') }}" enctype="multipart/form-data" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="text-center mb-2">
                            <img @if ($user->image != null) src="{{ asset('storage/admin_image/' . $user->image) }}"
                            @elseif ($user->gender == 'male')
                            src="{{ asset('images/default_profile.webp') }}"
                            @else
                            src="{{ asset('images/default_female.jpg') }}" @endif
                                alt="profile image" class="img-fluid object-fit-cover rounded-circle"
                                style="width:200px;height:200px">
                        </div>
                        <label for="image" class="fw-bold text-info">Upload Photo</label>
                        <small>Recommended Size 400 x 200</small>
                        <div class="input-group mt-1">
                            <input type="file" name="image" id="image" class="form-control"
                                id="floatingInputGroup1">
                            <span class="input-group-text">
                                <i class="fa-solid fa-image"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 table-responsive">
                        <table class="table table-striped mt-3">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="name">Name</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="name" id="name" placeholder="Your name"
                                            value="{{ old('name', $user->name) }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="email">Email</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="email" name="email" id="email" placeholder="Your email"
                                            value="{{ old('email', $user->email) }}"
                                            class="form-control @error('email') is-invalid @enderror" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="role">Role</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" name="role" id="role" class="form-control" disabled
                                            value="{{ $user->role }}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="phone">Phone</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="number" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="Enter phone number" value="{{ old('phone', $user->phone) }}"
                                            required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="address">Address</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                            placeholder="Enter address" required>{{ old('address', $user->address) }}</textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="gender">Gender</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <select name="gender" id="gender"
                                            class="form-select @error('gender') is-invalid @enderror">
                                            <option value="male"
                                                {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('adminProfile.index') }}" class="btn btn-sm btn-secondary mt-2">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-info mt-2">
                            <i class="fa-solid fa-up-long"></i>
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
