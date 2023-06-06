@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <div class="card shadow mb-4 col-12">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-center">Change Password
            </h6>
        </div>
        <div class="card-body">
            <div class="row my-4">
                <div class="col-md-4 offset-md-4 bg-light py-3">
                    <form action="{{ route('userPassword.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="old-password" class="text-black fw-bold">Old Password</label>
                            <input type="password" name="old_password" id="old-password"
                                class="form-control @error('old_password') is-invalid @enderror @if (session('error')) is-invalid @endif mt-2"
                                placeholder="Old password" required>
                            @error('old_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (session('error'))
                                <div class="invalid-feedback">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="text-black fw-bold">New Password</label>
                            <input type="password" name="new_password" id="new-password"
                                class="form-control @error('new_password') is-invalid @enderror mt-2"
                                placeholder="New password" required>
                            @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="text-black fw-bold">Confirm Password</label>
                            <input type="password" name="confirm_password" id="confirm-password"
                                class="form-control @error('confirm_password') is-invalid @enderror mt-2"
                                placeholder="Confirm password" required>
                            @error('confirm_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="float-end">
                            <button type="submit" class="btn btn-warning">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
