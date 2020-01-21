@extends('layouts.frontend')

@section('content')
    <div class="content content-full mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-7">
                <div class="text-center">
                    <h1 class="h2 mb-0">Create Account</h1>
                    <p class="lead">Just a few details and you're on your way!</p>

                    <form action="{{ route('auth.register.post') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <input class="form-control @error('name') is-invalid @enderror" type="text" placeholder="Name" name="name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('name') is-invalid @enderror" type="email" placeholder="Email Address" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('name') is-invalid @enderror" type="password" placeholder="Password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('confirm_password') is-invalid @enderror" type="password" placeholder="Confirm Password" name="confirm_password">
                            @error('confirm_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group pb-5">
                            <button class="btn btn-block btn-shadow-primary" role="button" type="submit">
                                Create Account
                            </button>
                        </div>

                        <small>
                            Already have an account?
                            <a href="{{ route('auth.login') }}">Login</a>
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
