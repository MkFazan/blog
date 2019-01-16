<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{route('home')}}">{{ config('app.name', 'Laravel') }}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categories
                </a>
                <div class="dropdown-menu badge-dark" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item badge-dark" href="{{route('categories')}}">All</a>
                    <div class="dropdown-divider badge-dark"></div>
                    @foreach($categories as $id => $category)
                        <a class="dropdown-item badge-dark" href="{{route('category', ['category' => $id])}}">{{$category}}</a>
                    @endforeach
                </div>
            </li>
            @foreach($pages as $id => $page)
                <li class="nav-item">
                    <a class="nav-link" href="#">{{$page}}<span class="sr-only">(current)</span></a>
                </li>
            @endforeach
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
    <div>
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}<span class="sr-only">(current)</span></a>
                </li>
            @else
                <li class="nav-item">
                    @if(auth()->user()->isAdmin())
                        <a class="nav-link" href="{{ route('dashboard') }}">My account<span class="sr-only">(current)</span></a>
                    @else
                        <a class="nav-link" href="{{ route('account') }}">My account<span class="sr-only">(current)</span></a>
                    @endif
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}<span class="sr-only">(current)</span></a>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </ul>
    </div>
</nav>
