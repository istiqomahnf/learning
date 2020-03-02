<!DOCTYPE html>
<html>
<head>
    <title>Index Page</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <style type="text/css">
            .table{
                font-size: 12px;
            }
        </style>
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
    <div class="container col-sm-10" style="padding-top: 30px;">
        <div class="row float-right" style="padding-bottom: 10px;"><button type="button" class="btn btn-primary" id="btn_add"> Add</button>&nbsp;&nbsp;&nbsp; <br></div><br><br>
        <table class="table table-bordered table-striped" id = "datatabel">
            <thead>
                <tr>
                    <th><center>Nama</center></th>
                    <th><center>Address</center></th>
                    <th class="text-center">Age</th>
                    <th class="text-center">Grade</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody id="content">

            </tbody>
        </table>
    </div>
    <div class="modal fade" role="dialog" id="modaledit">
      <div class="modal-dialog" role="document" >
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form_edit">
                <input type="hidden" name="id" value="" id="id">
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label>Nama</label>
                    </div>   
                    <div class="col-sm-9">
                        <input type="text" name="name" class="form-control" value="" id="name">
                    </div> 
                </div>
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label>Address</label>
                    </div>   
                    <div class="col-sm-9">
                        <input type="text" name="address" class="form-control" value="" id="address">
                    </div> 
                </div>
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label>Age</label>
                    </div>   
                    <div class="col-sm-9">
                        <input type="text" name="age" class="form-control" value="" id="age">
                    </div> 
                </div>
                <div class="row form-group">
                    <div class="col-sm-3">
                        <label>Grade</label>
                    </div>   
                    <div class="col-sm-9">
                        <select class="form-control" name="grade" id="grade">
                            <option value="">-Select Grade-</option>
                            @foreach($grade as $val)
                            <option value="{{$val->id}}">{{$val->grade}}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btn_save">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            table_data();
            get_token();
            var token = "{{ Session::get('header')}}";
            console.log(token);
        });

        function table_data(){
            // $.ajax({
            //     url: '/api/viewstudent',
            //     type: 'GET',
            //     beforeSend: function (xhr) {
            //         xhr.setRequestHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MTkxOTkxNCwiZXhwIjoxNTgxOTIzNTE0LCJuYmYiOjE1ODE5MTk5MTQsImp0aSI6Inp2N3dmaW9pQzY1ckZ4OEciLCJzdWIiOjIyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SpFmmLNlaqD1J0VSeU01kl8aAvn_gg2c0Asm2ld9ww8');
            //     },
            //     dataType: 'JSON',
            //     success: function(data){
            //         // var table = '';
            //         for(var i = 0; i <data.result.length; i ++){
            //            var tr = $('<tr>').append(
            //            $('<td>'+data.result[i].name+'</td>'),
            //            $('<td>'+data.result[i].address +'</td>'),
            //            $('<td>'+data.result[i].age +'</td>'),
            //            $('<td>'+data.result[i].grade.grade +'</td>'),
            //            $('<td><button class="btn btn-warning btn-sm" onclick="edit('+data.result[i].id+')">Edit</button> | <button class="btn btn-danger btn-sm" onclick="delete_id('+data.result[i].id+')">Delete</button></td>'),
            //            ).appendTo('#content');
            //         }
            //     }
            // });
            $("#datatabel").DataTable({
                processing: true,
                serverside: true,
                "bDestroy": true,
                ajax: {
                    url: '/api/viewstudent',
                    method: "GET",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MTkxOTkxNCwiZXhwIjoxNTgxOTIzNTE0LCJuYmYiOjE1ODE5MTk5MTQsImp0aSI6Inp2N3dmaW9pQzY1ckZ4OEciLCJzdWIiOjIyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SpFmmLNlaqD1J0VSeU01kl8aAvn_gg2c0Asm2ld9ww8');
                    },
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'address', name: 'address'},
                    {data: 'age', name: 'age'},
                    {data: 'grade.grade', name: 'grade'},
                    {data: 'action', name: 'action'}
                ],
                'columnDefs': [
                    {
                        "targets": [2,3,4],
                        "className": "text-center",
                    }
                ],
            });
        }

        function edit(id){
            $("#modaledit").modal('show');
            $.ajax({
                url: '/api/student/edit',
                type: "POST",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MTkxOTkxNCwiZXhwIjoxNTgxOTIzNTE0LCJuYmYiOjE1ODE5MTk5MTQsImp0aSI6Inp2N3dmaW9pQzY1ckZ4OEciLCJzdWIiOjIyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SpFmmLNlaqD1J0VSeU01kl8aAvn_gg2c0Asm2ld9ww8');
                },
                data: {id: id},
                dataType: "JSON",
                success: function(data){
                    $("#id").val(data.id);
                    $("#name").val(data.name);
                    $("#address").val(data.address);
                    $("#age").val(data.age);
                    $("#grade").val(data.grade_id).change();
                }
            });
        }

        function delete_id(id){
            if (confirm("Delete data ? ")) {
                $.ajax({
                    url: '/api/student/delete/'+id,
                    type: "DELETE",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MTkxOTkxNCwiZXhwIjoxNTgxOTIzNTE0LCJuYmYiOjE1ODE5MTk5MTQsImp0aSI6Inp2N3dmaW9pQzY1ckZ4OEciLCJzdWIiOjIyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SpFmmLNlaqD1J0VSeU01kl8aAvn_gg2c0Asm2ld9ww8');
                    },
                    // data: {id: id},
                    dataType: "JSON",
                    success: function(data){
                        if (data) {
                            alert("Data successfully Deleted");
                            $("#content").empty();
                            table_data();
                        }else{
                            alert("Data Failed to Delete");
                        }
                    }
                });
            }
        }

        $("#btn_save").on('click', function(){
            $.ajax({
                url: '/api/student/update',
                type: 'PUT',
                dataType: "JSON",
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU4MTkxOTkxNCwiZXhwIjoxNTgxOTIzNTE0LCJuYmYiOjE1ODE5MTk5MTQsImp0aSI6Inp2N3dmaW9pQzY1ckZ4OEciLCJzdWIiOjIyLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.SpFmmLNlaqD1J0VSeU01kl8aAvn_gg2c0Asm2ld9ww8');
                },
                data: $("#form_edit").serialize(),
                success: function(data){
                    if (data) {
                        $("#modaledit").modal('hide');
                        alert("Success Update Data");
                        $("#content").empty();
                        table_data();
                    }else{
                        alert("Error Update Data");
                    }
                }
            });
        });

        $("#btn_add").on('click', function(){
            window.open('/adddata','_self');
        });

        function get_token(){
            $.ajax({
                url: '/api/bear',
                type: 'GET',
                dataType: "JSON",
                success: function(data){
                   console.log(data);
                }
            });
        }
    </script>
</body>
</html>