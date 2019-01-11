@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    {{$title . ' '}}category
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <form class="needs-validation" method="post" action="{{isset($category) ? route('categories.update', ['category' => $category->id]) : route('categories.store')}}" novalidate>
                            @csrf
                            @if(isset($category))
                                @method('PUT')
                            @endif
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="name" value="{{isset($category) ? $category->name : old('email')}}" required>
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
                                    <input type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" id="validationCustom02" placeholder="Description" name="description" value="{{isset($category) ? $category->email : old('email')}}" {{isset($user) ? 'readonly' : ''}} required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('description'))
                                            {{ $errors->first('description') }}
                                        @else
                                            Example invalid custom input feedback
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">Root category</label>
                                    <select class="custom-select" name="parent_id" required>
                                        <option value="{{null}}">Is root</option>
                                        @foreach($categories as $id => $title)
                                            <option value="{{$id}}" {{isset($category) ? (($category->parent_id == $id) ? 'selected' : '') : ''}}>{{$title}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('parent_id'))
                                            {{ $errors->first('parent_id') }}
                                        @else
                                            Example invalid custom select feedback
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Meta title</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_title') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Meta title" name="meta_title" value="{{isset($category) ? $category->meta_title : old('meta_title')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_title'))
                                            {{ $errors->first('meta_title') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Meta description</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_description') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="meta_description" value="{{isset($category) ? $category->meta_description : old('meta_description')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_description'))
                                            {{ $errors->first('meta_description') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Meta keywords</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_keywords') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="meta_keywords" value="{{isset($category) ? $category->meta_keywords : old('meta_keywords')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_keywords'))
                                            {{ $errors->first('meta_keywords') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
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

@endsection
