@extends('frontend.layouts.app')

@section('content')

    <div class="container">
        @include('frontend.partial.statistic')
    </div>

    <div class="container">
    <div class="card">
        <div class="card-body">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="{{ asset('images/slide/slide_1.jpg') }}" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Slide 1</h5>
                        <p>Text slide 1</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('images/slide/slide_2.jpg') }}" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Slide 2</h5>
                        <p>Text slide 2</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('images/slide/slide_3.jpg') }}" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Slide 3</h5>
                        <p>Text slide 3</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
        </div>
    </div>

@endsection
