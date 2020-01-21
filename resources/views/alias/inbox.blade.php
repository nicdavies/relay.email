@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">{{ $alias->name }}</h2>
        <h3 class="h5 font-w400 text-muted">{{ $alias->completeAlias }}</h3>
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
    @endif
@endsection
