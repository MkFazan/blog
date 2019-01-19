@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Filter article</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <form method="post" class="w-100" action="{{route('filter')}}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Name</label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Name" name="name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom02">Description</label>
                                <input type="text" class="form-control" id="validationCustom02" placeholder="Description" name="description">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Meta title</label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Meta title" name="meta_title">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Meta description</label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Meta description" name="meta_description">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Meta keywords</label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Meta keywords" name="meta_keywords">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="validationCustom01">Author name</label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Author name" name="author_name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="validationCustom02">Categories</label>
                                <select class="js-example-basic-multiple" name="categories[]" multiple="multiple">
                                    <option value="{{null}}">Selected categories ... </option>
                                    @php getNodesSelect($nodes, ' - ', []) @endphp
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
            @if(!empty($articles))
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
