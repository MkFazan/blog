@extends('backend.layouts.dashboard')

@section('style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .main-section{
            margin:0 auto;
            padding: 20px;
            margin-top: 100px;
            background-color: #fff;
            box-shadow: 0px 0px 20px #c1c1c1;
        }
        .fileinput-remove,
        .fileinput-upload{
            display: none;
        }
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
                    Article
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('articles.create')}}" >Create new artilce</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <table class="table table-hover table-dark">
                            <thead>
                            <tr>
                                <th scope="col">Logo</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Categories</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th><img class="my_style" src="{{$article->logotype->url}}"></th>
                                <td><a class="btn btn-outline-light btn-sm" href="#">{{$article->name}}</a></td>
                                <td>{{mb_strimwidth($article->description, 0, 10, "...")}}</td>
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
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    Article gallery image
                </h3>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <table class="table table-hover table-dark">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Display name</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($article->gallery as $image)
                            <tr>
                                <th scope="row">1</th>
                                <th>{{$image->display_name}}</th>
                                <th>{{$image->name}}</th>
                                <th><img class="my_style" src="{{$image->url}}"></th>
                                <th>
                                    <form id="delete_{{$image->pivot_image_id}}" method="post" action="{{route('delete.image.in.gallery')}}">
                                        @csrf
                                        <input type="hidden" name="image_id" value="{{$image->pivot->image_id}}">
                                        <input type="hidden" name="article_id" value="{{$image->pivot->article_id}}">

                                        <a class="btn btn-danger" href="#" onclick="document.getElementById('delete_'{{$image->pivot_image_id}}).submit()">Delete</a>
                                    </form>
                                </th>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12 col-11 main-section">
                            <h1 class="text-center text-danger">Image for gallery</h1><br>
                            @csrf
                            <input type="hidden" name="article_id" value="{{$article->id}}">
                            <div class="form-group">
                                <div class="file-loading">
                                    <input id="file-1" type="file" name="file" multiple class="file" data-overwrite-initial="false" data-min-file-count="2">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>

    <script type="text/javascript">
        $("#file-1").fileinput({
            theme: 'fa',
            uploadUrl: "/dashboard/add-img",
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val(),
                    article: $("input[name='article_id']").val()
                };
            },
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            overwriteInitial: false,
            maxFileSize:2000,
            maxFilesNum: 10,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });
    </script>

@endsection

