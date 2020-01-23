@extends('layouts.frontend')

@section('content')
    <div class="content content-full mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-7">
                <div class="text-center">
                    <h1 class="h2 mb-0">Forgot Password?</h1>
                    <p class="lead">Enter your email and we'll get you back in, in no time!</p>

                    <form action="{{ route('auth.forgot.post') }}" method="post" class="py-3">
                        @csrf

                        <div class="form-group">
                            <input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Email Address" name="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group pb-5">
                            <button class="btn btn-block btn-primary" role="button" type="submit">Send!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
