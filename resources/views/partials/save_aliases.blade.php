{{-- SAVE ALIASES --}}
<div class="d-flex justify-content-between align-items-center mt-5 mb-3">
    <h2 class="h4 font-w300 mb-0">Aliases ({{ $total['total'] }})</h2>
    <button type="button" class="btn btn-primary btn-sm btn-rounded" onclick="Dashmix.block('open', '#add-alias');">
        <i class="fa fa-plus mr-1"></i> Add Alias
    </button>
</div>

<div id="add-alias" class="block bg-body-light animated fadeIn d-none">
    <div class="block-header">
        <h3 class="block-title">Add a new Alias</h3>
        <div class="block-options">
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>

    <div class="block-content">
        <form action="{{ route('alias.store') }}" method="post">
            @csrf

            <div class="form-group row gutters-tiny items-push">
                <div class="col-md-5">
                    <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias">
                </div>

                <div class="col-md-4">
                    <select class="custom-select" id="action" name="action">
                        <option value="SAVE">Save</option>
                        <option value="IGNORE">Ignore</option>
                        <option value="FORWARD">Forward</option>
                        <option value="FORWARD_AND_SAVE">Forward And Save</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fa fa-plus mr-1"></i> Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="cb-add-mailbox" class="block bg-body-light animated fadeIn d-none">
    <div class="block-header">
        <h3 class="block-title">Add a new Alias</h3>
        <div class="block-options">
            <button type="button" class="btn-block-option">
                <i class="fa fa-question"></i>
            </button>

            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">
                <i class="fa fa-close"></i>
            </button>
        </div>
    </div>

    <div class="block-content">
        <form action="">
            <div class="form-group row gutters-tiny mb-0 items-push">
                <div class="col-md-5">
                    <input type="text" class="form-control" id="example-hosting-mailbox" name="example-hosting-mailbox" placeholder="Mailbox Name">
                </div>
                <div class="col-md-4">
                    <select class="custom-select" id="example-hosting-domains" name="example-hosting-domains">
                        <option value="0">Select a domain</option>
                        <option value="1">@example.com</option>
                        <option value="2">@example.co.uk</option>
                        <option value="3">@example.io</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-alt-success btn-block">
                        <i class="fa fa-plus mr-1"></i> Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($aliases as $alias)
<div class="block border-bottom mb-0 mt-1">
    <div class="block-content block-content-full border-bottom">
        <div class="row align-items-center">
            <div class="col-sm-6 py-2">
                <h3 class="h5 font-w700">
                    {{ $alias->completeAlias }}<span class="text-muted">
                        @ {{ config('app.app_mail_domain') }}
                    </span>
                </h3>

{{--                TODO: eventually get around to displaying a properly calculated progress-bar --}}
{{--                <div class="progress" style="height: 8px;">--}}
{{--                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 12%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                </div>--}}

                <p class="font-size-sm font-w600 mb-0">
                    <span class="font-w700">{{ $alias->messages->count() }}</span> of <span class="font-w700">500</span> Messages
                </p>
            </div>

            <div class="col-sm-6 text-md-right">
                <div class="dropdown">
                    <a class="btn btn-sm btn-outline-secondary btn-rounded" href="{{ route('alias.show', $alias) }}">
                        <i class="fa fa-eye"></i> View
                    </a>

                    <button type="button" class="btn btn-sm btn-outline-secondary btn-rounded dropdown-toggle" id="dropdown-default-light" data-toggle="dropdown">
                        Options
                    </button>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('inbox.list', $alias) }}">Inbox</a>
                        <a class="dropdown-item" href="{{ route('alias.settings', $alias) }}">Settings</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" onclick="document.getElementById('delete-{{ $alias->uuid }}').submit();">Delete</a>
                    </div>
                </div>

                <form action="{{ route('alias.destroy', $alias) }}" id="delete-{{ $alias->uuid }}" method="post" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
