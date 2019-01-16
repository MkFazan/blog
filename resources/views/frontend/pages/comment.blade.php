<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="container">
            <div class="row">
                <div class="col-4">
                    <div class="card m-3">
                        <div class="container m-2">
                            <p class="card-title">Author</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">16.12.19</li>
                        </ul>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card m-3">
                        <div class="container m-2">
                            <p class="card-title">fefwe</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header m-2" id="headingOne">
                <h2 class="mb-0 float-right">
                    <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Answer comment
                    </button>
                </h2>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body">
                    <div class="container">
                        <div class="card ml-5 pt-2">
                            <div class="container">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="card m-3">
                                            <div class="container m-2">
                                                <p class="card-title">Author</p>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">16.12.19</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card m-3">
                                            <div class="container m-2">
                                                <p class="card-title">fefwe</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card ml-5 pt-2">
                    @include('frontend.partial.comment_form_article', [
                        'child' => true,
                        'article_id' => 2,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
