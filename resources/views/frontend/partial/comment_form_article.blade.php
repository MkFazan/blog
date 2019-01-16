<div class="container">
    <form method="post" id="comment_{{$article_id}}_{{$parent_id}}" action="{{route('comments.store')}}">
        @csrf
        <input type="hidden" name="article_id" value="{{$article_id}}">
        <input type="hidden" name="parent_id" value="{{$parent_id}}">
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
                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
            </div>
        </div>
        <div class="row justify-content-end p-2">
            <div class="col-auto float-right">
                <a style="cursor: pointer" onclick="document.getElementById('comment_{{$article_id}}_{{$parent_id}}').submit()" class="btn btn-secondary">Send comment</a>
            </div>
        </div>
    </form>
</div>
