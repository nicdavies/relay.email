<div class="border-bottom">
    <div class="py-0">
        <ul class="nav nav-tabs nav-tabs-alt border-bottom-0 justify-content-center justify-content-md-start">
            <li class="nav-item">
                <a class="nav-link text-white py-4 {{ Route::is('alias.show') ? 'active' : '' }}" href="{{ route('alias.show', $alias) }}">
                    <i class="fa fa-rocket fa-fw text-gray"></i>
                    <span class="d-none d-md-inline ml-1">
                                    Overview
                                </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white py-4 {{ Route::is('inbox.list') ? 'active' : '' }}" href="{{ route('inbox.list', $alias) }}">
                    <i class="fa fa-envelope-open fa-fw text-gray"></i>
                    <span class="d-none d-md-inline ml-1">
                                    Inbox
                                </span>
                </a>
            </li>

            <li class="nav-item pull-right">
                <a class="nav-link text-white py-4 {{ Route::is('alias.settings') ? 'active' : '' }}" href="{{ route('alias.settings', $alias) }}">
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
