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
                <a class="nav-link text-white py-4 {{ Route::is('inbox.list') || Route::is('inbox.message.read') ? 'active' : '' }}" href="{{ route('inbox.list', $alias) }}">
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
        </ul>
    </div>
</div>
