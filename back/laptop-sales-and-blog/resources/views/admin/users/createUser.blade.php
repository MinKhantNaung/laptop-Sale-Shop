@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Create User')
@section('content')
    <div class="card shadow mb-4 col-12">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-center">
                Create a user and assign his role
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.createUser') }}" enctype="multipart/form-data" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 offset-md-3 table-responsive">
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
                                        <input type="text" name="name" id="name" placeholder="Name"
                                            value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="email">Email</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="email" name="email" id="email" placeholder="Email"
                                            value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="role">Role</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <select name="role" id="role" class="form-select">
                                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
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
                                            placeholder="Phone number" value="{{ old('phone') }}"
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
                                            placeholder="Address" required>{{ old('address') }}</textarea>
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
                                                {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female"
                                                {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="password">Password</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="password" name="password" id="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="confirmPassword">Confirm Password</label>
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm password" class="form-control @error('confirmPassword') is-invalid @enderror">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="#" onclick="history.back()" class="btn btn-sm btn-secondary mt-2">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-info mt-2">
                            <i class="fa-solid fa-circle-plus"></i>
                            Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
