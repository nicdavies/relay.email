@extends('layouts.app')

@section('content')
    <div class="bg-dark mb-5">
        <div class="bg-black-25">
            @include('partials.alias_header')
            @include('partials.alias_nav')
        </div>
    </div>

    <div class="block block-fx-pop">
        <div class="block-content block-content-sm block-content-full bg-body-light">
            <div class="media py-3">
                <div class="media-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <a class="font-w600 link-fx" href="javascript:void(0)">{{ $message->sender }}</a>
                            <div class="font-size-sm text-muted">{{ $message->from }}</div>
                        </div>

                        <div class="col-sm-5 d-sm-flex align-items-sm-center">
                            <div class="font-size-sm font-italic text-muted text-sm-right w-100 mt-2 mt-sm-0">
                                <p class="mb-0">{{ $message->created_at->toFormattedDateString() }}</p>
                                <p class="mb-0">{{ $message->created_at->toTimeString() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block-content py-4">
            {{ $message->body_plain }}
        </div>

        {{-- TODO: if there's attachments, render them below --}}
{{--        <div class="block-content bg-body-light">--}}
{{--            <div class="row gutters-tiny">--}}
{{--                <div class="col-4 col-xl-2">--}}
{{--                    <div class="options-container fx-item-rotate-r">--}}
{{--                        <img class="img-fluid options-item" src="assets/media/photos/photo16.jpg" alt="">--}}
{{--                        <div class="options-overlay bg-black-75">--}}
{{--                            <div class="options-overlay-content">--}}
{{--                                <a class="btn btn-sm btn-primary" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-download"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <p class="font-size-sm text-muted pt-2">--}}
{{--                        <i class="fa fa-paperclip"></i> 1a.jpg (785Kb)--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="col-4 col-xl-2">--}}
{{--                    <div class="options-container fx-item-rotate-r">--}}
{{--                        <img class="img-fluid options-item" src="assets/media/photos/photo4.jpg" alt="">--}}
{{--                        <div class="options-overlay bg-black-75">--}}
{{--                            <div class="options-overlay-content">--}}
{{--                                <a class="btn btn-sm btn-primary" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-download"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <p class="font-size-sm text-muted pt-2">--}}
{{--                        <i class="fa fa-paperclip"></i> 1b.jpg (685kb)--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                <div class="col-4 col-xl-2">--}}
{{--                    <div class="options-container fx-item-rotate-r">--}}
{{--                        <img class="img-fluid options-item" src="assets/media/photos/photo9.jpg" alt="">--}}
{{--                        <div class="options-overlay bg-black-75">--}}
{{--                            <div class="options-overlay-content">--}}
{{--                                <a class="btn btn-sm btn-primary" href="javascript:void(0)">--}}
{{--                                    <i class="fa fa-download"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <p class="font-size-sm text-muted pt-2">--}}
{{--                        <i class="fa fa-paperclip"></i> 1c.jpg (698kb)--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
