@extends('layouts.frontend')

@section('content')
    <div class="content content-full mt-5">
        <div class="row justify-content-center mt-5">
            <div class="col-xl-5 col-lg-6 col-md-7">
                <div class="text-center">
                    <h1 class="h2 mb-0">Welcome Back &#x1f44b;</h1>
                    <p class="lead">Log in to your account to continue</p>

                    <form action="{{ route('auth.login.post') }}" method="post" class="py-3">
                        @csrf

                        <div class="form-group">
                            <input class="form-control" type="email" placeholder="Email Address" name="email" v-model="email">
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="password" placeholder="Password" name="password" v-model="password">
                            <div class="text-right">
                                <small><a href="{{ route('auth.forgot') }}">Forgot password?</a></small>
                            </div>
                        </div>

                        <div class="form-group pb-5">
                            <button class="btn btn-block btn-primary" role="button" type="submit">Log in</button>
                        </div>

                        <small>
                            Don't have an account yet? <a href="#">Create one</a>
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
