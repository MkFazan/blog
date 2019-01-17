@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{$page->name}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="container m-2">
                            <p class="card-text">{{$page->text}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
