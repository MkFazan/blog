@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Category: {{isset($category) ? ucfirst($category->name) : 'All'}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($articles as $article)
                        <div class="col-sm-4">
                            <div class="container m-2">
                                <div class="card w-auto">
                                    <img src="{{$article->logotype->url}}" class="card-img-top w-25 h-25 m-2" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="{{route('article', ['article' => $article->id])}}" class="btn btn-light">{{ucfirst($article->name)}}</a></h5>
                                        <p class="card-text">Categories:
                                            @foreach($article->category as $cat)
                                                <span class="badge badge-info">{{ucfirst($cat->name) . ' '}}</span>
                                            @endforeach
                                        </p>
                                        <p class="card-text">Author: {{$article->author->name}}</p>
                                        <p class="card-text">{{$article->created_at}}</p>
                                    </div>
                                    <div class="card-body">
                                        <a href="{{route('change.status.favorite.article', ['id' => $article->id])}}" class="card-link">{{in_array($article->id, $favoriteArticles) ? 'Delete' : 'Add'}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="container align-items-center">
                <nav style="width: max-content; margin: auto;">
                    <ul class="pagination pagination-sm">
                        {{ $articles->links() }}
                    </ul>
                </nav>
            </div>
            <div class="container align-items-center">
                <div class="form-group">
                    <label>Articles in page</label>
                    <select onchange="reload(this.value)">
                        <option value="{{config('app.paginate')}}">{{config('app.paginate')}}</option>
                        <option {{$paginate==20 ? 'selected' : ''}} value="20">20</option>
                        <option {{$paginate==50 ? 'selected' : ''}} value="50">50</option>
                        <option {{$paginate==100 ? 'selected' : ''}} value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <script>
        function reload(val) {
            var route = '{{isset($category) ? 'true' : 'false'}}';
            if (route){
                window.location = '{{route('categories')}}' + '/' + val;
            } else {
                window.location = '{{route('category', ['category' => $route])}}' + '/' + val;
            }
        }
    </script>

@endsection
