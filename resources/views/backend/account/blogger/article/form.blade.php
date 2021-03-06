@extends('backend.layouts.dashboard')


@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    {{$title . ' '}}article
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <form enctype="multipart/form-data" class="needs-validation" method="post" action="{{isset($article) ? route('blogger.articles.update', ['articles' => $article->id]) : route('blogger.articles.store')}}" novalidate>
                            <input type="hidden" name="MAX_FILE_SIZE" value="{{config('app.max_file_size')}}" />
                            @csrf
                            @if(isset($article))
                                @method('PUT')
                            @endif
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="name" value="{{isset($article) ? $article->name : old('name')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('name'))
                                            {{ $errors->first('name') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">Description</label>
                                    <input type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="validationCustom02" placeholder="Description" name="description" value="{{isset($article) ? $article->description : old('description')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('description'))
                                            {{ $errors->first('description') }}
                                        @else
                                            Example invalid custom input feedback
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validatedCustomFile">Logo image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" name="logo" required>
                                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                            @if ($errors->has('logo'))
                                            <div class="alert" style="color:red;" role="alert">
                                                {{ $errors->first('logo') }}
                                            </div>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="meta_title">Meta title</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_title') ? ' is-invalid' : '' }}" id="meta_title" placeholder="Meta title" name="meta_title" value="{{isset($article) ? $article->meta_title : old('meta_title')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_title'))
                                            {{ $errors->first('meta_title') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="meta_description">Meta description</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_description') ? ' is-invalid' : '' }}" id="meta_description" placeholder="Name" name="meta_description" value="{{isset($article) ? $article->meta_description : old('meta_description')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_description'))
                                            {{ $errors->first('meta_description') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="meta_keywords">Meta keywords</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_keywords') ? ' is-invalid' : '' }}" id="meta_keywords" placeholder="Name" name="meta_keywords" value="{{isset($article) ? $article->meta_keywords : old('meta_keywords')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_keywords'))
                                            {{ $errors->first('meta_keywords') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{isset($article) ? (($article->status == 1) ? 'checked' : '') : 'checked'}} name="status" value="1" id="invalidCheckStatus">
                                            <label class="form-check-label" for="invalidCheckStatus">
                                                Active article?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" {{isset($article) ? (($article->public == 1) ? 'checked' : '') : 'checked'}} name="public" value="1" id="invalidCheck">
                                            <label class="form-check-label" for="invalidCheck">
                                                Public article?
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="categories">Categories</label>
                                    <select class="js-example-basic-multiple" name="categories[]" id="categories" multiple="multiple" required>
                                        <option value="{{null}}" disabled>Selected categories ... </option>
                                        @php getNodesSelect($nodes, ' - ', isset($article) ? $article->category->pluck('id')->toArray() : []) @endphp
                                    </select>
                                        @if ($errors->has('categories'))
                                            <div class="alert" style="color:red;" role="alert">
                                            {{ $errors->first('categories') }}
                                            </div>
                                        @endif
                                </div>
                            </div>

                            <div class="container-fluid m-2">
                                <span style="color: darkred;">
                                <strong>{{session('error')}}</strong>
                                </span>
                            </div>
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')

    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>

@endsection
