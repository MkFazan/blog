<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card m-3">
                <div class="container m-2">
                    <p class="card-title">{{ucfirst(auth()->user()->name)}}</p>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="form-group m-2">
                <label for="exampleFormControlTextarea1">Text comment</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>
    </div>
    <div class="row justify-content-end p-2">
        <div class="col-auto float-right">
            <a href="#" class="btn btn-secondary">Send comment</a>
        </div>
    </div>
</div>
