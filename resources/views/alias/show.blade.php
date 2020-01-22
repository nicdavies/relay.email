@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">{{ $alias->name }}</h2>
        <h3 class="h5 font-w400 text-muted mb-2">{{ $alias->completeAlias }}</h3>

        <a class="btn btn-sm btn-outline-secondary btn-rounded mb-2" href="{{ route('inbox.list', $alias) }}">
            <i class="fa fa-globe"></i>
            View Inbox
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="block block-rounded block-bordered block-fx-shadow">
                <div class="block-content py-5">
                    <form action="{{ route('alias.update', $alias) }}" method="post">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label class="col-12" for="name">Name</label>
                            <div class="col-12">
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" id="name" value="{{ $alias->name }}">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="alias">Alias</label>
                            <div class="col-12">
                                <input type="text" class="form-control form-control-lg" id="alias" value="{{ $alias->alias }}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="action">Action</label>
                            <div class="col-12">
                                <select class="form-control form-control-lg" id="action" name="action">
                                    <option value="SAVE">Save</option>
                                    <option value="IGNORE">Ignore</option>
                                    <option value="FORWARD">Forward</option>
                                    <option value="FORWARD_AND_SAVE">Forward And Save</option>
                                </select>

                                @error('action')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-lg btn-block btn-hero-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection