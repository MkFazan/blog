@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>{{ucfirst($article->name)}}</h3>
            </div>
            <div class="card w-auto">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 ">
                            <img src="{{$article->logotype->url}}" class="card-img-top m-3" alt="...">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            @foreach($article->gallery as  $image)
                                <img src="{{$image->url}}" class="d-block w-25 float-left" alt="{{$image->display_name}}">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">{{$article->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Keywords: <span class="badge badge-primary">{{$article->meta_keywords}}</span></li>
                </ul>
                <div class="card-body">
                    <li class="list-group-item">Favorite: &nbsp;&nbsp; <a href="{{route('change.status.favorite.article', ['id' => $article->id])}}" class="btn btn-secondary">{{in_array($article->id, $favoriteArticles) ? 'Delete' : 'Add'}}</a></li>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h3>Comments</h3>
            </div>
            <div class="card w-auto m-2">
                @include('frontend.pages.comment',[
                    'comments' => $article->comments,
                    'article_id' => $article->id
                ])
                @auth
                    @include('frontend.partial.comment_form_article',[
                        'parent_id' => null,
                        'article_id' => $article->id,
                    ])
                @else
                    <h3 class="text-center">Please login to add comments</h3>
                @endauth
            </div>
        </div>
    </div>

@endsection
