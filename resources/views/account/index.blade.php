@extends('layouts.app')

@section('content')
    <div class="text-center mt-5 py-3">
        <h2 class="h3 font-w700 mb-2">Account</h2>
        <h3 class="h5 font-w400 text-muted">Update your settings here.</h3>
    </div>

    <div class="block block-rounded block-fx-shadow">
        <div class="block-content">
            <form action="{{ route('account.update.general') }}" method="post">
                @csrf
                @method('PATCH')

                <h2 class="content-heading text-black">Account Details</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            Update your basic account details!
                        </p>
                    </div>

                    <div class="col-lg-7 offset-lg-1">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-shadow-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('account.update.gpg') }}" method="post">
                @csrf
                @method('PATCH')

                <h2 class="content-heading text-black">GPG</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            By adding your GPG key, all your messages will be encrypted.
                        </p>
                        <p class="text-muted">
                            You can choose to encrypt <strong>forward</strong> and <strong>save</strong> messages in your alias settings.
                        </p>
                    </div>

                    <div class="col-lg-7 offset-lg-1">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="gpg_key">GPG Public Key</label>
                                @if($user->currentGpgKey !== null)
                                    <textarea class="form-control @error('gpg_key') is-invalid @enderror" id="gpg_key" name="gpg_key" rows="4" placeholder="Begins with '-----BEGIN PGP PUBLIC KEY BLOCK-----'">{{ $user->currentGpgKey->gpg_key }}</textarea>
                                @else
                                    <textarea class="form-control @error('gpg_key') is-invalid @enderror" id="gpg_key" name="gpg_key" rows="4" placeholder="Begins with '-----BEGIN PGP PUBLIC KEY BLOCK-----'"></textarea>
                                @endif

                                @error('gpg_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <div class="col-12">
                                <button type="submit" class="btn btn-shadow-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('account.update.password') }}" method="post">
                @csrf
                @method('PATCH')

                <h2 class="content-heading text-black">Account Security</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            Changing your sign in password is an easy way to keep your account secure.
                        </p>
                    </div>

                    <div class="col-lg-7 offset-lg-1">
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">

                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">

                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input type="password" class="form-control @error('confirm_new_password') is-invalid @enderror" name="confirm_new_password">

                                @error('confirm_new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-5">
                            <div class="col-12">
                                <button type="submit" class="btn btn-shadow-primary">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
