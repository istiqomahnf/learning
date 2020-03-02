<!DOCTYPE html>
<html>
<head>
    <title>Add Page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="/">Home <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="/about">About</a>
        </div>
      </div>
    </nav>
    <div class="container" style="padding-top: 30px;">
        <div class="alert alert-danger print-error-msg col-sm-8" style="display:none">
            <ul></ul>
        </div>
        <form id="form_add">
            {{csrf_field()}}
            <input type="hidden" name="id" value="">
            <div class="row form-group">
                <div class="col-sm-2">
                    <label>Nama</label>
                </div>   
                <div class="col-sm-6">
                    <input type="text" name="name" class="form-control" value="">
                </div> 
            </div>
            <div class="row form-group">
                <div class="col-sm-2">
                    <label>Address</label>
                </div>   
                <div class="col-sm-6">
                    <input type="text" name="address" class="form-control" value="">
                </div> 
            </div>
            <div class="row form-group">
                <div class="col-sm-2">
                    <label>Age</label>
                </div>   
                <div class="col-sm-6">
                    <input type="text" name="age" class="form-control" value="">
                </div> 
            </div>
            <div class="row form-group">
                <div class="col-sm-2">
                    <label>Grade</label>
                </div>   
                <div class="col-sm-6">
                    <select class="form-control" name="grade" id="grade">
                        <option value="">-Select Grade-</option>
                        @foreach($grade as $val)
                        <option value="{{$val->id}}">{{$val->grade}}</option>
                        @endforeach
                    </select>
                </div> 
            </div>
            <div class="col-sm-8">
                <button type="button" class="btn btn-primary float-right" id="btn_add">Save</button>
            </div>
            
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <script type="text/javascript">
        $("#btn_add").on('click', function(){
            $.ajax({
                url: "/api/student",
                type: "POST",
                dataType: "JSON",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MDc4NTcwMiwiZXhwIjoxNTgwNzg5MzAyLCJuYmYiOjE1ODA3ODU3MDIsImp0aSI6InU5cWN0MVBYTWUzclJCQkUiLCJzdWIiOjIwLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.jaWJG04oJD7hmw3xi_yJfRiqMIcRvm1IaGbvEEwsW_A');
                },
                data: $("#form_add").serialize(),
                success: function(data){
                    if (data == "success") {
                        alert("Success");
                        window.open('/', '_self');
                    }else{
                        printerror(data.error);
                    }
                }
            });
        });

        function printerror(data){
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( data, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    </script>
</body>
</html>