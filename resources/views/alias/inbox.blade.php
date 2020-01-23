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

    @if($alias->message_action !== 'SAVE' && $alias->message_action !== 'SAVE_AND_FORWARD')
        <div class="text-center mt-5 py-3">
            <h2 class="h3 font-w700 mb-2">Uh Oh!</h2>
            <h3 class="h5 font-w400 text-muted">This alias is not set up to receive email!</h3>

            <a href="{{ route('alias.show', $alias) }}" class="btn btn-sm btn-info">
                <i class="fa fa-arrow-left fa-fw"></i>
                Go Back
            </a>
        </div>
    @else
        <div class="block block-rounded block-mode-loading-refresh">
            <div class="block-header block-header-default">
                <h3 class="block-title">Messages</h3>
            </div>

            <div class="block-content">
                <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                    <thead>
                    <tr class="text-uppercase">
                        <th class="font-w700">Product</th>
                        <th class="d-none d-sm-table-cell font-w700">Date</th>
                        <th class="font-w700">State</th>
                        <th class="d-none d-sm-table-cell font-w700 text-right" style="width: 120px;">Price</th>
                        <th class="font-w700 text-center" style="width: 60px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>
                                    <span class="font-w600">{{ $message->from }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">today</span>
                                </td>
                                <td>
                                    <span class="font-w600 text-warning">Pending..</span>
                                </td>
                                <td class="d-none d-sm-table-cell text-right">
                                    $999,99
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
