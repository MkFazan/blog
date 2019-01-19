<div class="accordion" id="accordionExample">
    @if(!empty($comments))
    @foreach($comments as $comment)
        <div class="card">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <div class="card m-3">
                            <div class="container m-2">
                                <p class="card-title">{{$comment->author->name}}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{$comment->created_at}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card m-3">
                            <div class="container m-2">
                                <p class="card-title">{{$comment->text}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header m-2" id="heading_{{$comment->id}}">
                    <h2 class="mb-0 float-right">
                        <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapse_{{$comment->id}}" aria-expanded="true" aria-controls="collapse_{{$comment->id}}">
                            Answer comment
                        </button>
                    </h2>
                </div>
                <div id="collapse_{{$comment->id}}" class="collapse" aria-labelledby="heading_{{$comment->id}}" data-parent="#accordionExample">
                    @if(!empty($answerComments))
                    @foreach($answerComments as $answer)
                        @if($answer->parent_id == $comment->id)
                        <div class="card-body">
                            <div class="container">
                                <div class="card ml-5 pt-2">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="card m-3">
                                                    <div class="container m-2">
                                                        <p class="card-title">{{$answer->author->name}}</p>
                                                    </div>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item">{{$answer->created_at}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="card m-3">
                                                    <div class="container m-2">
                                                        <p class="card-title">{{$answer->text}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endif
                    @endforeach
                    @endif
                    @auth
                        <div class="card ml-5 pt-2">
                            @include('frontend.partial.comment_form_article', [
                                'parent_id' => $comment->id,
                                'article_id' => $article_id,
                            ])
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    @endforeach
    @endif
</div>
