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
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('blogger.articles.create')}}" >Create new article</a>
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
                                <th scope="col">Status</th>
                                <th scope="col">Public</th>
                                <th scope="col">Categories</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $key => $article)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <th><img class="my_style" src="{{$article->logotype->url}}"></th>
                                    <td><a class="btn btn-outline-light btn-sm" href="{{route('blogger.articles.show', ['id' => $article->id])}}">{{$article->name}}</a></td>
                                    <td>{{$article->status == STATUS_ACTIVE ? 'Active' : 'Disable'}}</td>
                                    <td>{{$article->public == STATUS_ACTIVE ? 'Active' : 'Disable'}}</td>
                                    <td>
                                        <div class="btn-group">
                                            @foreach($article->category as $category)
                                                {{$category->name}}
                                            @endforeach
                                        </div>
                                    </td>
                                    <td><a class="btn btn-warning" href="{{route('blogger.articles.edit', ['article' => $article->id])}}">Edit</a></td>
                                    <td>
                                        <form id="delete_{{$article->id}}" method="post" action="{{route('blogger.articles.destroy', ['article' => $article->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <a class="btn btn-danger" style="cursor: pointer"
                                               onclick="document.getElementById('delete_{{$article->id}}').submit()">Delete</a>
                                        </form>
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
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>
        function reload(val) {
            window.location = '{{route('my.article')}}' + '/' + val;
        }
    </script>
@endsection
