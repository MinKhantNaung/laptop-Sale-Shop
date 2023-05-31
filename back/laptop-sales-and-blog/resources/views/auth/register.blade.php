@extends('auth.layouts.guest')

@section('title', 'Join MM-Laptops')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h3 class="text-center mb-4">
            <i class="fa-solid fa-user"></i>
        </h3>
        <h3 class="text-center mb-4">Register to MM-Laptops</h3>
        <div class="card bg-light">
            <div class="card-body">
                <div>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" placeholder="Your name"
                        class="form-control mt-2 @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-4">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="Your email"
                        class="form-control mt-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password"
                        class="form-control mt-2 @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confrim password"
                        class="form-control mt-2 @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-4">
                    <input type="submit" value="Register" class="btn btn-success w-100">
                </div>
            </div>
        </div>
    </form>

    <div class="text-center w-100 mt-4 py-2 border border-2">Alread registered?
        <a href="{{ route('login') }}" class="text-decoration-none">Login here</a>
    </div>
@endsection
