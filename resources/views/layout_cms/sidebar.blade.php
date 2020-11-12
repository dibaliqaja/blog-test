<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">BLOGTEST</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">BT</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ (request()->routeIs('dashboard')) ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Starter</li>
            <li class="{{ (request()->routeIs('categories*')) ? 'active' : '' }}">
                <a href="{{ route('categories.index') }}" class="nav-link">
                    <i class="fas fa-list-alt"></i><span>Categories</span>
                </a>
            </li>
            <li class="{{ (request()->routeIs('posts*')) ? 'active' : '' }}">
                <a href="{{ route('posts.index') }}" class="nav-link">
                    <i class="fas fa-file-signature"></i><span>Post</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
