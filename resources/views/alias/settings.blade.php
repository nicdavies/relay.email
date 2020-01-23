@extends('layouts.app')

@section('content')
    <div class="bg-dark mb-5">
        <div class="bg-black-25">
            @include('partials.alias_header')
            @include('partials.alias_nav')
        </div>
    </div>

    <div class="block block-rounded block-fx-shadow">
        <div class="block-content">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('account.update.general') }}" method="post">
                @csrf
                @method('PATCH')

                <h2 class="content-heading text-black">General</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            Update your basic account details!
                        </p>
                    </div>

                    <div class="col-lg-7 offset-lg-1">
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="name">Name</label>--}}
{{--                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">--}}

{{--                                @error('name')--}}
{{--                                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group row">--}}
{{--                            <div class="col-12">--}}
{{--                                <label for="email">Email Address</label>--}}
{{--                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">--}}

{{--                                @error('email')--}}
{{--                                <div class="invalid-feedback">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('alias.update.action', $alias) }}" method="post">
                @csrf
                @method('PATCH')

                <h2 class="content-heading text-black">Actions</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            Actions are what we do with emails as soon as they arrive.
                        </p>
                    </div>

                    <div class="col-lg-7 offset-lg-1">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="action">Action</label>
                                <select class="form-control" id="action" name="action">
                                    <option value="SAVE" @if($alias->message_action == 'SAVE') selected="selected" @endif>Save</option>
                                    <option value="IGNORE" @if($alias->message_action == 'IGNORE') selected="selected" @endif>Ignore</option>
                                    <option value="FORWARD" @if($alias->message_action == 'FORWARD') selected="selected" @endif>Forward</option>
                                    <option value="FORWARD_AND_SAVE" @if($alias->message_action == 'FORWARD_AND_SAVE') selected @endif>Forward And Save</option>
                                </select>

                                @error('action')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row" id="forward_to_group">
                            <label class="col-12" for="forward_to">Forward To</label>
                            <div class="col-12">
                                <input
                                    type="email"
                                    class="form-control @error('forward_to') is-invalid @enderror"
                                    name="forward_to"
                                    id="forward_to"
                                    value="{{ $alias->message_forward_to }}"
                                    placeholder="{{ Auth::user()->email }}">

                                @error('forward_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <div class="col-12">
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('alias.destroy', $alias) }}" method="post">
                @csrf
                @method('DELETE')

                <h2 class="content-heading text-black">Danger Zone</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            Changing your sign in password is an easy way to keep your account secure.
                        </p>
                    </div>

                    <div class="col-lg-7 offset-lg-1">
                        <div class="form-group row mb-5">
                            <div class="col-12">
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
