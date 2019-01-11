@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    Users
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('users.create')}}" >Create new user</a>
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
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Status</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            </thead>
                            <tbody>
                           @foreach($users as $key => $user)
                            <tr>
                                <th scope="row">{{++$key}}</th>
                                <th>{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$roles[$user->role]}}</td>
                                <td>{{$user->status==1 ? 'Active' : 'Disabled'}}</td>
                                <td><a class="btn btn-warning" href="{{route('users.edit', ['user' => $user->id])}}">Edit</a></td>
                                <td>
                                    <form id="delete_{{$user->id}}" method="post" action="{{route('users.destroy', ['user' => $user->id])}}">
                                        @method('DELETE')
                                        @csrf
                                        <a class="btn btn-danger" style="cursor: pointer"
                                           onclick="document.getElementById('delete_{{$user->id}}').submit()">Delete</a>
                                    </form>
                                </td>
                            </tr>
                           @endforeach
                            </tbody>
                        </table>

                        <div class="container align-items-center">
                            <nav style="width: max-content; margin: auto;">
                                <ul class="pagination pagination-sm">
                                    {{ $users->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
