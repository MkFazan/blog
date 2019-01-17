@extends('backend.layouts.dashboard')

@section('content')

    <section class="col-lg-12 connectedSortable">
        <div class="card">
            <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                    <i class="fa fa-pie-chart mr-1"></i>
                    Categories
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: auto;">
                        <table class="table table-hover table-dark">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Author</th>
                                <th scope="col">text</th>
                                <th scope="col">Created</th>
                                <th scope="col" {{isset($moderation) ? 'colspan="2"' : ''}}></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $key => $comment)
                                <tr>
                                    <th scope="row">{{++$key}}</th>
                                    <th>{{$comment->author->name}}</th>
                                    <td>{{$comment->text}}</td>
                                    <td>{{$comment->created_at}}</td>
                                    @if(isset($moderation))
                                        <td><a class="btn btn-warning" href="{{route('comments.approve', ['comment' => $comment->id])}}">Approve</a></td>
                                    @endif
                                    <td><a class="btn btn-warning" href="{{route('comments.delete', ['comment' => $comment->id])}}">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="container align-items-center">
                            <nav style="width: max-content; margin: auto;">
                                <ul class="pagination pagination-sm">
                                    {{ $comments->links() }}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
