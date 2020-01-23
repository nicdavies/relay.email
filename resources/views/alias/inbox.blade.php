@extends('layouts.app')

@section('content')
    <div class="bg-dark mb-5">
        <div class="bg-black-25">
            @include('partials.alias_header')
            @include('partials.alias_nav')
        </div>
    </div>

    @if($alias->message_action !== 'SAVE' && $alias->message_action !== 'SAVE_AND_FORWARD')
        <div class="text-center mt-5 py-3">
            <h2 class="h3 font-w700 mb-2">Uh Oh!</h2>
            <h3 class="h5 font-w400 text-muted">This alias is not set up to receive email!</h3>

            <a href="{{ route('alias.settings', $alias) }}" class="btn btn-sm btn-info">
                <i class="fa fa-arrow-right fa-fw"></i>
                Change Settings
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
                        <th class="font-w700">Subject</th>
                        <th class="font-w700">From</th>
                        <th class="d-none d-sm-table-cell font-w700">Date</th>
                        <th class="font-w700 text-center" style="width: 60px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($messages as $message)
                            <tr>
                                <td>
                                    <span class="font-w600">{{ $message->subject }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">{{ $message->from }}</span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span class="font-size-sm text-muted">{{ $message->created_at }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('inbox.message.read', ['alias' => $alias, 'message' => $message]) }}">
                                        <i class="fa fa-fw fa-eye"></i>
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
