@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    Pages
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{route('pages.create')}}" >Create new pages</a>
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
                                <th scope="col">Name</th>
                                <th scope="col">Meta title</th>
                                <th scope="col">Meta description</th>
                                <th scope="col">Meta keywords</th>
                                <th scope="col">Status</th>
                                <th scope="col" colspan="2"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $key => $page)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <td><a class="btn btn-outline-light btn-sm" href="{{route('pages.show', ['id' => $page->id])}}">{{$page->name}}</a></td>
                                    <td>{{$page->meta_title}}</td>
                                    <td>{{$page->meta_description}}</td>
                                    <td>{{$page->meta_keywords}}</td>
                                    <td>{{$page->status==STATUS_ACTIVE ? 'Active' : 'Disabled'}}</td>
                                    <td><a class="btn btn-warning" href="{{route('pages.edit', ['page' => $page->id])}}">Edit</a></td>
                                    <td>
                                        <form id="delete_{{$page->id}}" method="post" action="{{route('pages.destroy', ['page' => $page->id])}}">
                                            @method('DELETE')
                                            @csrf
                                            <a class="btn btn-danger" style="cursor: pointer"
                                               onclick="document.getElementById('delete_{{$page->id}}').submit()">Delete</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="container align-items-center">
                            <nav style="width: max-content; margin: auto;">
                                <ul class="pagination pagination-sm">
                                    {{ $pages->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
