{{-- SAVE ALIASES --}}
<div class="d-flex justify-content-between align-items-center mt-5 mb-3">
    <h2 class="h4 font-w300 mb-0">Aliases ({{ $total['total'] }})</h2>
    <a href="{{ route('alias.create') }}" class="btn btn-primary btn-sm btn-alt-primary btn-rounded">
        <i class="fa fa-plus mr-1"></i> Add Alias
    </a>
</div>

{{--<div id="cb-add-mailbox" class="block bg-body-light animated fadeIn d-none">--}}
{{--    <div class="block-header">--}}
{{--        <h3 class="block-title">Add a new Alias</h3>--}}
{{--        <div class="block-options">--}}
{{--            <button type="button" class="btn-block-option">--}}
{{--                <i class="fa fa-question"></i>--}}
{{--            </button>--}}

{{--            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="close">--}}
{{--                <i class="fa fa-close"></i>--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="block-content">--}}
{{--        <form action="">--}}
{{--            <div class="form-group row gutters-tiny mb-0 items-push">--}}
{{--                <div class="col-md-5">--}}
{{--                    <input type="text" class="form-control" id="example-hosting-mailbox" name="example-hosting-mailbox" placeholder="Mailbox Name">--}}
{{--                </div>--}}
{{--                <div class="col-md-4">--}}
{{--                    <select class="custom-select" id="example-hosting-domains" name="example-hosting-domains">--}}
{{--                        <option value="0">Select a domain</option>--}}
{{--                        <option value="1">@example.com</option>--}}
{{--                        <option value="2">@example.co.uk</option>--}}
{{--                        <option value="3">@example.io</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="col-md-3">--}}
{{--                    <button type="submit" class="btn btn-alt-success btn-block">--}}
{{--                        <i class="fa fa-plus mr-1"></i> Create--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}

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
                    {{ $alias->completeAlias }}<span class="text-muted">@relay.com</span>
                </h3>

                <div class="progress" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 12%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <p class="font-size-sm font-w600 mb-0">
                    <span class="font-w700">{{ $alias->messages->count() }}</span> of <span class="font-w700">500</span> Messages
                </p>
            </div>

            <div class="col-sm-6 text-md-right">
                <a class="btn btn-sm btn-outline-secondary btn-rounded" href="{{ route('inbox.list', $alias) }}">
                    <i class="fa fa-globe"></i> Inbox
                </a>

                <a class="btn btn-sm btn-outline-secondary btn-rounded" href="{{ route('alias.show', $alias) }}">
                    <i class="fa fa-wrencg"></i> Settings
                </a>

                <a class="btn btn-sm btn-outline-danger btn-rounded" href="#" onclick="document.getElementById('delete-{{ $alias->uuid }}').submit();">
                    <i class="fa fa-times"></i> Delete
                </a>

                <form action="{{ route('alias.destroy', $alias) }}" id="delete-{{ $alias->uuid }}" method="post" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
