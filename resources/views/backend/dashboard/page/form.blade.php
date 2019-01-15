@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    {{$title . ' '}}page
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <form class="needs-validation" method="post" action="{{isset($page) ? route('pages.update', ['page' => $page->id]) : route('pages.store')}}" novalidate>
                            @csrf
                            @if(isset($page))
                                @method('PUT')
                            @endif
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="name" value="{{isset($page) ? $page->name : old('name')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('name'))
                                            {{ $errors->first('name') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Meta title</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_title') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Meta title" name="meta_title" value="{{isset($page) ? $page->meta_title : old('meta_title')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_title'))
                                            {{ $errors->first('meta_title') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Meta keywords</label>
                                    <input type="text" class="form-control{{ $errors->has('meta_keywords') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="meta_keywords" value="{{isset($page) ? $page->meta_keywords : old('meta_keywords')}}" required>
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
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom02">Meta description</label>
                                    <textarea class="form-control{{ $errors->has('meta_description') ? ' is-invalid' : '' }}" id="validationCustom02" rows="3" placeholder="Meta description" name="meta_description" required>{{isset($page) ? $page->meta_description : old('meta_description')}}</textarea>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('meta_description'))
                                            {{ $errors->first('meta_description') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="validationCustom02">Text</label>
                                    <textarea class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" id="validationCustom02" rows="3" placeholder="Text" name="text" required>{{isset($page) ? $page->text : old('text')}}</textarea>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('text'))
                                            {{ $errors->first('text') }}
                                        @else
                                            Example invalid custom input feedback
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" {{isset($page) ? (($page->status == 1) ? 'checked' : '') : ''}} name="status" value="1" id="invalidCheck">
                                    <label class="form-check-label" for="invalidCheck">
                                        Active user?
                                    </label>
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
