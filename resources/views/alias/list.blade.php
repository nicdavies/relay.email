@extends('layouts.app')

@section('content')
    <div class="mb-8">
        <h2 class="h4 font-w300 mt-6">Overview</h2>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full text-center">
                        <div class="p-20 mb-5">
                            <i class="fa fa-3x fa-save text-success"></i>
                        </div>
                        <p class="font-size-lg font-w600 mb-0">
                            {{ $total['save'] }} Save
                        </p>
                        <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                            Aliases
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full text-center">
                        <div class="p-20 mb-5">
                            <i class="fa fa-3x fa-eye-slash text-success"></i>
                        </div>
                        <p class="font-size-lg font-w600 mb-0">
                            {{ $total['ignore'] }} Ignore
                        </p>
                        <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                            Aliases
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full text-center">
                        <div class="p-20 mb-5">
                            <i class="fa fa-3x fa-share-square text-success"></i>
                        </div>
                        <p class="font-size-lg font-w600 mb-0">
                            {{ $total['forward'] }} Forward
                        </p>
                        <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                            Aliases
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="block block-rounded">
                    <div class="block-content block-content-full text-center">
                        <div class="p-20 mb-5">
                            <i class="fa fa-3x fa-exchange text-success"></i>
                        </div>
                        <p class="font-size-lg font-w600 mb-0">
                            {{ $total['forwardAndSave'] }} Forward & Save
                        </p>
                        <p class="font-size-sm text-uppercase font-w600 text-muted mb-0">
                            Aliases
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.save_aliases')

        <div class="text-center mt-5 py-3">
            {{ $aliases->links() }}
        </div>
    </div>
@endsection
