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

            <div class="border-bottom">
                <div class="py-0">
                    <ul class="nav nav-tabs nav-tabs-alt border-bottom-0 justify-content-center justify-content-md-start">
                        <li class="nav-item">
                            <a class="nav-link text-white py-4 active" href="{{ route('home') }}">
                                <i class="fa fa-rocket fa-fw text-gray"></i>
                                <span class="d-none d-md-inline ml-1">
                                    Overview
                                </span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-white py-4" href="{{ route('inbox.list', $alias) }}">
                                <i class="fa fa-envelope-open fa-fw text-gray"></i>
                                <span class="d-none d-md-inline ml-1">
                                    Inbox
                                </span>
                            </a>
                        </li>

                        <li class="nav-item pull-right">
                            <a class="nav-link text-white py-4" href="{{ route('alias.show', $alias) }}">
                                <i class="fa fa-cog fa-fw text-gray"></i>
                                <span class="d-none d-md-inline ml-1">
                                    Settings
                                </span>
                            </a>
                        </li>

                        <li class="nav-item ml-auto d-none d-md-flex align-items-center mr-4">
                            <button type="button" class="btn btn-sm btn-danger d-none d-lg-inline-block mb-1" onclick="document.getElementById('delete-form').submit();">
                                <i class="fa fa-trash fa-fw mr-1"></i> Delete
                            </button>
                        </li>

                        <form action="{{ route('alias.destroy', $alias) }}" method="post" id="delete-form">
                            @csrf
                            @method('DELETE')
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
                <tr>
                    <td>
                        <span class="font-w600">iPhone X</span>
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
                <tr>
                    <td>
                        <span class="font-w600">MacBook Pro 15"</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">today</span>
                    </td>
                    <td>
                        <span class="font-w600 text-warning">Pending..</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $2.299,00
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-w600">Nvidia GTX 1080 Ti</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">today</span>
                    </td>
                    <td>
                        <span class="font-w600 text-warning">Pending..</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $1200,00
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-w600">Playstation 4 Pro</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">today</span>
                    </td>
                    <td>
                        <span class="font-w600 text-danger">Cancelled</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $399,00
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-w600">Nintendo Switch</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">yesterday</span>
                    </td>
                    <td>
                        <span class="font-w600 text-success">Completed</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $349,00
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-w600">iPhone X</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">yesterday</span>
                    </td>
                    <td>
                        <span class="font-w600 text-success">Completed</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $999,00
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-w600">Echo Dot</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">yesterday</span>
                    </td>
                    <td>
                        <span class="font-w600 text-success">Completed</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $39,99
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="font-w600">Xbox One X</span>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">yesterday</span>
                    </td>
                    <td>
                        <span class="font-w600 text-success">Completed</span>
                    </td>
                    <td class="d-none d-sm-table-cell text-right">
                        $499,00
                    </td>
                    <td class="text-center">
                        <a href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="" class="js-tooltip-enabled" data-original-title="Manage">
                            <i class="fa fa-fw fa-pencil-alt"></i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
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
