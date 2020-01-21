@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">Welcome {{ Auth::user()->name }} 👋</h2>
        <h3 class="h5 font-w400 text-muted">You have {{ $total['messages'] }} messages!</h3>
    </div>

    <h2 class="h4 font-w300 mt-6">Overview</h2>
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x fa-globe text-primary"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ $total['save'] }} Save
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Aliases
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x fa-server text-elegance"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ $total['ignore'] }} Ignore
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Aliases
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x fa-dot-circle-o text-pulse"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ $total['forward'] }} Forward
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Aliases
                    </p>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3">
            <a class="block block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-5">
                        <i class="fa fa-3x fa-cc-paypal text-gray-dark"></i>
                    </div>
                    <p class="font-size-lg font-w600 mb-0">
                        {{ $total['forwardAndSave'] }} Forward & Save
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                        Aliases
                    </p>
                </div>
            </a>
        </div>
    </div>

    @include('partials.save_aliases')
{{--    @include('partials.forward_aliases')--}}
{{--    @include('partials.ignore_aliases')--}}
@endsection
