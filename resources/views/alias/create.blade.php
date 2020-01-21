@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">Create Alias</h2>
        <h3 class="h5 font-w400 text-muted">Let's get you started!</h3>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="block block-rounded block-bordered block-fx-shadow">
                <div class="block-content py-5">
                    <form action="{{ route('alias.store') }}" method="post">
                        @csrf

                        <div class="form-group row">
                            <label class="col-12" for="name">Alias Name</label>
                            <div class="col-12">
                                <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" name="name" id="name" placeholder="netflix">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-12" for="alias">Alias</label>
                            <div class="col-12">
                                <input type="text" class="form-control form-control-lg @error('alias') is-invalid @enderror" name="alias" id="alias" placeholder="ntflx">

                                @error('alias')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <button type="submit" class="btn btn-lg btn-block btn-hero-primary">Done!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
