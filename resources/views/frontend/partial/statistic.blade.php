<div class="card">
    <div class="card-header">
        <h5 class="card-title"><span class="badge badge-danger">TOP</span> &nbsp; Statistics</h5>
    </div>
    <div class="card-body">
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Bloggers<span class="badge badge-pill badge-info">{{count($bloggers)}}</span>
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="row">
                        @foreach($bloggers as $blogger)
                            <div class="col-sm-4">
                                <div class="container m-2">
                                    <div class="card w-auto">
                                        <div class="card-body">
                                            <h5 class="card-title"><a href="#" class="card-link">{{ucfirst($blogger->name)}}</a></h5>
                                        </div>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item">Articles: <span class="badge badge-secondary">{{count($blogger->articles)}}</span></li>
                                            <li class="list-group-item">Favorite articles: <span class="badge badge-secondary">{{count($blogger->favorite)}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-info collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                             Articles <span class="badge badge-pill badge-info">{{count($bestArticles)}}</span>
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="row">
                    @foreach($bestArticles as $article)
                        <div class="col-sm-4">
                            <div class="container m-2">
                                <div class="card w-auto">
                                    <img src="{{$article->logotype->url}}" class="card-img-top w-25 h-25 m-2" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title"><a href="{{route('article', ['article' => $article->id])}}" class="btn btn-light">{{ucfirst($article->name)}}</a></h5>
                                        <p class="card-text">{{mb_strimwidth($article->description, 0, 50, "...")}}</p>
                                        <p class="card-text">Author: {{$article->author->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
