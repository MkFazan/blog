<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('images/default-icon.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Dashboard</li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-users-cog"></i>
                    <p>
                        Users
                        <i class="fa fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link">
                            <i class="fas fa-users"></i>
                            <p>List users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('users.create')}}" class="nav-link">
                            <i class="fas fa-user-plus"></i>
                            <p>Create new</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-layer-group"></i>
                    <p>
                        Categories
                        <i class="fa fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('categories.index')}}" class="nav-link">
                            <i class="fas fa-bars"></i>
                            <p>List categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('categories.create')}}" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <p>Create new</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    <p>
                        Articles
                        <i class="fa fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('articles.index')}}" class="nav-link">
                            <i class="fas fa-bars"></i>
                            <p>List articles</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('articles.create')}}" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <p>Create new</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    <p>
                        Pages
                        <i class="fa fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('pages.index')}}" class="nav-link">
                            <i class="fas fa-bars"></i>
                            <p>List pages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('pages.create')}}" class="nav-link">
                            <i class="fas fa-plus"></i>
                            <p>Create new</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="fas fa-newspaper"></i>
                    <p>
                        Comments
                        <i class="fa fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('comments.index')}}" class="nav-link">
                            <i class="fas fa-bars"></i>
                            <p>List all comments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('comments.moderation')}}" class="nav-link">
                            <i class="fas fa-bars"></i>
                            <p>List comments for moderation</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <p>
                        {{ __('Logout') }}
                    </p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </a>
            </li>
        </ul>
    </nav>
</div>
