@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    {{$title . ' '}}user
                </h3>
            </div>
            <div class="card-header d-flex p-0">
                <div class="alert alert-warning" role="alert">
                    {{$message}}
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('delete.information.user')}}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Password</label>
                                    <input type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Password" name="password" value="{{old('password')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
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
                            <button class="btn btn-primary" type="submit">Delete</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

@endsection
