@extends('layouts.app')

@section('content')
    <div class="bg-dark mb-5">
        <div class="bg-black-25">
            @include('partials.alias_header')
            @include('partials.alias_nav')
        </div>
    </div>

    <div class="block block-rounded block-mode-loading-refresh">
        <div class="block-header block-header-default">
            <h3 class="block-title">Settings and tha</h3>
        </div>

        <div class="block-content">
            <button type="button" class="btn btn-sm btn-danger d-none d-lg-inline-block mb-1" onclick="document.getElementById('delete-form').submit();">
                <i class="fa fa-trash fa-fw mr-1"></i> Delete
            </button>
            <form action="{{ route('alias.destroy', $alias) }}" method="post" id="delete-form">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection
