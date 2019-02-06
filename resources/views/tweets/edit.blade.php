<html>
<head>
    <title>
    </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</head>
<style>
    .twitt {
        margin-bottom: 30px;

    }
</style>
<body>
<div class="container">
    <div class="jumbotron">
        <h1>Edit a Twitt</h1>

        <form action="{{ route('tweets.update' , $tweet->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div>
                <input type="text" name="title" class="form-control twitt" value="{{$tweet->title}}">
            </div>
            <div>
                <textarea type="text" name="body" class="form-control twitt" >{{$tweet->body}}</textarea>
            </div>
            <div>
                <input type="submit" value="Edit">
            </div>
        </form>
        @if($errors->any())
            <div>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>{{$error}}</li>

                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
</body>
</html>