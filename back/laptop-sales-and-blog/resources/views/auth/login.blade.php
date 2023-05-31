@extends('auth.layouts.guest')
@section('title', 'Login to MM-Laptops')

@section('content')

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h3 class="text-center mb-4">
            <i class="fa-solid fa-user"></i>
        </h3>
        <h3 class="text-center mb-4">Login to MM-Laptops</h3>
        @if (session('successMsg'))
            <div class="alert alert-success">
                <i class="fa-solid fa-check"></i>
                {{ session('successMsg') }}
            </div>
        @endif
        <div class="card bg-light">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <p><strong>Opps Something went wrong</strong></p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <div>
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" placeholder="Enter email address"
                        class="form-control mt-2 @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                </div>

                <div class="mt-4">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password"
                        class="form-control mt-2 @error('password') is-invalid @enderror" required>
                </div>

                <div class="mt-4">
                    <input type="submit" value="Login" class="btn btn-success w-100">
                </div>
            </div>
        </div>
    </form>

    <div class="text-center w-100 mt-4 py-2 border border-2">New?
        <a href="{{ route('register') }}" class="text-decoration-none">Create an account.</a>
    </div>
@endsection
