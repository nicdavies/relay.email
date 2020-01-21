@extends('layouts.frontend')

@section('content')
    <div class="content content-full mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-7">
                <div class="text-center">
                    <h1 class="h2 mb-0">Reset Password</h1>
                    <p class="lead"></p>

                    <form action="{{ route('auth.reset.post', ['token' => $token]) }}" method="post" class="py-3">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" type="password" placeholder="New Password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" placeholder="Confirm New Password" name="password_confirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group pb-5">
                            <button class="btn btn-block btn-shadow-primary" role="button" type="submit">Send!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
