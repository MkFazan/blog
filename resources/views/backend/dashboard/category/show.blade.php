@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    Categories
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('categories.create')}}" >Create new category</a>
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
                                <th scope="col">Description</th>
                                <th scope="col">Children</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <th>{{$category->id}}</th>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->description}}</td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            @if($category->descendants)
                                                @foreach($category->descendants as $item)
                                                    @if ($item->parent_id==$category->id)
                                                        <p><a class="btn btn-outline-success" href="{{ route('categories.show', ['id' => $item->id]) }}">{{$item->name}}</a></p>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                    <td><a class="btn btn-warning" href="{{route('categories.edit', ['category' => $category->id])}}">Edit</a></td>
                                    <td>
                                        <form id="delete_{{$category->id}}" method="post" action="{{route('categories.destroy', ['category' => $category->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <a class="btn btn-danger" style="cursor: pointer"
                                               onclick="document.getElementById('delete_{{$category->id}}').submit()">Delete</a>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="container">
                <ul id="tree1">
                    @php getNodes($nodes, ' - ') @endphp
                </ul>
            </div>
        </div>
    </section>

@endsection
