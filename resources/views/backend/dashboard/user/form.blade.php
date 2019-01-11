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
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <form class="needs-validation" method="post" action="{{isset($user) ? route('users.update', ['user' => $user->id]) : route('users.store')}}" novalidate>
                            @csrf
                            @if(isset($user))
                                @method('PUT')
                            @endif
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom01">Name</label>
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="validationCustom01" placeholder="Name" name="name" value="{{isset($user) ? $user->name : old('email')}}" required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @else
                                            Name required!
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">Email</label>
                                    <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="validationCustom02" placeholder="Email" name="email" value="{{isset($user) ? $user->email : old('email')}}" {{isset($user) ? 'readonly' : ''}} required>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('email'))
                                            {{ $errors->first('email') }}
                                        @else
                                            Example invalid custom input feedback
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom02">User role</label>
                                    <select class="custom-select" name="role" required>
                                        <option value="{{null}}">Open this select menu</option>
                                        @foreach($roles as $id => $role)
                                            <option value="{{$id}}" {{isset($user) ? (($user->role == $id) ? 'selected' : '') : ''}}>{{$role}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('role'))
                                            {{ $errors->first('role') }}
                                        @else
                                            Example invalid custom select feedback
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="form-row">
                                @if(isset($user))
                                    <div class="col-md-4 mb-3">
                                        <label for="validationCustom04">Current password</label>
                                        <input type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" id="validationCustom04" placeholder="current_password" name="current_password" required>
                                        <div class="invalid-feedback">
                                            @if ($errors->has('current_password'))
                                                {{ $errors->first('current_password') }}
                                            @else
                                                Example invalid custom input feedback
                                            @endif
                                        </div>
                                    </div>
                                @else
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom03">Password</label>
                                    <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="validationCustom03" placeholder="password" name="password" {{isset($user) ? '' : 'required'}}>
                                    <div class="invalid-feedback">
                                        @if ($errors->has('password'))
                                            {{ $errors->first('password') }}
                                        @else
                                            Example invalid custom input feedback
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationCustom04">Password confirmed</label>
                                    <input type="password" class="form-control" id="validationCustom04" placeholder="password_confirmation" name="password_confirmation" {{isset($user) ? '' : 'required'}}>
                                    <div class="invalid-feedback">
                                            Example invalid custom input feedback
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" {{isset($user) ? (($user->status == 1) ? 'checked' : '') : ''}} name="status" value="1" id="invalidCheck">
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

@section('script')
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
@endsection
