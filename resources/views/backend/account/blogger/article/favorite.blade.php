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
                    {{$title}}
                </h3>
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
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $key => $article)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <th><img class="my_style" src="{{$article->logotype->url}}"></th>
                                    <td><a class="btn btn-outline-light btn-sm" href="#">{{$article->name}}</a></td>
                                    <td>{{$article->description}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @foreach($article->category as $category)
                                                <a href="#" class="btn btn-info btn-sm">{{$category->name}}</a>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><a class="btn btn-danger" href="{{route('change.status.favorite.article', ['article' => $article->id])}}">Delete</a></td>
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
