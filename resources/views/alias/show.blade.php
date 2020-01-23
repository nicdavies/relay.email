@extends('layouts.app')

@section('content')
    <div class="bg-dark mb-5">
        <div class="bg-black-25">
            <div class="row content content-full py-5">
                <div class="col-md-6 d-md-flex align-items-md-center">
                    <div class="py-4 py-md-0 text-center text-md-left js-appear-enabled animated fadeIn" data-toggle="appear">
                        <h1 class="font-size-h2 text-white mb-2">{{ $alias->name }}</h1>
                        <h2 class="font-size-lg font-w400 text-white-75 mb-0">{{ $alias->completeAlias }}</h2>
                    </div>
                </div>
            </div>

            @include('partials.alias_nav')
        </div>
    </div>
@endsection
