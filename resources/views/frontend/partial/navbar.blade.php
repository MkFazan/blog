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
                    @foreach(getCategoryForNavMenu() as $id => $category)
                        <a class="dropdown-item badge-dark" href="{{route('category', ['category' => $id])}}">{{$category}}</a>
                    @endforeach
                </div>
            </li>
            @foreach(getPagesForNavMenu() as $slug => $page)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('custom.page', ['slug' => $slug])}}">{{$page}}<span class="sr-only">(current)</span></a>
                </li>
            @endforeach
        </ul>
        <form class="form-inline my-2 my-lg-0" id="filter_article" method="post" action="{{route('filter')}}">
            @csrf
            <select class="js-example-data-ajax form-control w-100 float-right" onchange="runArticle(this.value)">
                <option>Search article for ......</option>
            </select>
                <a class="btn btn-outline-success my-2 my-lg-0" style="cursor:pointer;" onclick="document.getElementById('filter_article').submit()">Filter</a>
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

@section('script')

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $('.js-example-basic-multiple').select2();

        $(".js-example-data-ajax").select2({
            ajax: {
                url: "{{route('search.articles')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                }, processResults: function (data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Search for a repository',
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 1,
            templateResult: formatRepo,
            templateSelection: formatRepoSelection
        });

        function formatRepo (repo) {
            if (repo.loading) {
                return repo.text;
            }

            var markup = "<div class='select2-result-repository clearfix'>" + repo.name + "</div>";

            return markup;
        }

        function formatRepoSelection (repo) {
            return repo.name || repo.text;
        }

        function runArticle(url) {
            window.location = url;
        }
    </script>

@endsection
