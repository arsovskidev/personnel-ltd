<header class="header" id="header">
    <div class="header_toggle">
        <i class="bx bx-menu" id="header-toggle"></i>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="{{ route('calls.index') }}" class="nav_logo">
                <i class="bx bx-layer nav_logo-icon"></i>
                <span class="nav_logo-name">Personnel LTD</span>
            </a>
            <div class="nav_list">
                <a href="{{ route('calls.index') }}"
                    class="nav_link {{ request()->segment(1) == 'calls' ? 'active' : '' }}">
                    <i class="bx bxs-phone-call nav_icon"></i>
                    <span class="nav_name">Calls</span>
                </a>
                <a href="{{ route('users.index') }}"
                    class="nav_link {{ request()->segment(1) == 'users' ? 'active' : '' }}">
                    <i class="bx bxs-user nav_icon"></i>
                    <span class="nav_name">Users</span>
                </a>
                <a href="{{ route('resources.index') }}"
                    class="nav_link {{ request()->segment(1) == 'resources' ? 'active' : '' }}">
                    <i class="bx bxs-data nav_icon"></i>
                    <span class="nav_name">Resources</span>
                </a>

            </div>
        </div>
    </nav>
</div>
