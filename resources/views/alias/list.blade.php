@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">Welcome 👋</h2>
        <h3 class="h5 font-w400 text-muted">Let's get you started!</h3>
    </div>

    <p>Your Aliases</p>
    @include('partials.save_aliases')
@endsection
