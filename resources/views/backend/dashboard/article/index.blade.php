@extends('backend.layouts.dashboard')

@section('style')
    <style>
        .my_style{
            width: 50px; height: 50px
        }
    </style>
@endsection

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    Articles
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('articles.create')}}" >Create new article</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <table class="table table-hover table-dark">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Logo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Categories</th>
                                <th scope="col" colspan="2"></th>
                                <th scope="col">Best</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $key => $article)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <th><img class="my_style" src="{{$article->logotype->url}}"></th>
                                    <td><a class="btn btn-outline-light btn-sm" href="{{route('articles.show', ['id' => $article->id])}}">{{$article->name}}</a></td>
                                    <td>{{$article->description}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @foreach($article->category as $category)
                                                <a href="{{route('categories.show', ['id' => $category->id])}}" class="btn btn-info btn-sm">{{$category->name}}</a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><a class="btn btn-warning" href="{{route('articles.edit', ['article' => $article->id])}}">Edit</a></td>
                                    <td>
                                        <form id="delete_{{$article->id}}" method="post" action="{{route('articles.destroy', ['article' => $article->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <a class="btn btn-danger" style="cursor: pointer"
                                               onclick="document.getElementById('delete_{{$article->id}}').submit()">Delete</a>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-light btn-sm" href="{{route('change.status.favorite.article', ['id' => $article->id])}}">{{in_array($article->id, $best) ? 'Delete' : 'Add'}}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="container align-items-center">
                            <nav style="width: max-content; margin: auto;">
                                <ul class="pagination pagination-sm">
                                    {{ $articles->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
