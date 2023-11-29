<!DOCTYPE html>
<html>
<?php
    $listTask = App\Models\Tasks::where('user_id',auth()->user()->id)->get();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task Manager-Gallan Stefan Jayakelana</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <style>
        *{
            font-family: Arial;
        }
        body{
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background: url({{asset('blue.png')}});
        }
        .label-book{
            font-size: 22px;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px
        }
        .green-primary{
            background: rgb(38, 82, 41)
        }
        .input-form {
            height: 40px;
            border: solid 1px rgb(202, 202, 202);
            width: 100%;
            padding: 10px;
            margin-top: 20px;
        }
        .area-form {
            /* height: 100px; */
            border: solid 1px rgb(202, 202, 202);
            width: 100%;
            padding: 10px;
            margin-top: 20px;
        }
        .ck-editor__editable
        {
            min-height: 200px !important;
            max-height: 400px !important;
        }
        input[type=checkbox]{
            transform:scale(2);
        }
    </style>
</head>

<body>
    <div class="row">
        <div class="col-sm-4">
            <p class="mt-4 green-primary text-white p-2 fw-bold label-book">Selamat Datang <span style="color: rgb(225, 228, 50); margin-right: 5px;">{{ auth()->user()->name }}</span>
                <a href="{{ route('logout') }}" style="cursor: pointer" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();" class="btn btn-md btn-danger">LOGOUT</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </p>
            <div class="container text-end">
                <a href="{{ asset('user/task/create') }}" class="btn btn-primary">Buat Tugas Baru</a>
                <div class="list-group mt-3 text-start">
                    <span class="list-group-item list-group-item green-primary text-white fw-bold" aria-current="true">
                      Tugas Anda 
                    </span>
                    @foreach ($listTask as $item)
                    <div id="menu{{ $item->id }}" class="d-flex justify-content-between list-group-item list-group-item-action {{($task->id??null)==$item->id?'bg-success':''}}">
                        <div>
                            <a href="{{ asset('user/task?task_id='.$item->id) }}" class="text-decoration-none fw-bold {{($task->id??null)==$item->id?'text-white':'text-dark'}}">
                                <span>{{ $item->name }}</span>
                            </a>
                        </div>
                        <div>
                            <span>
                                <i id="check{{ $item->id }}" class="fas {{$item->status == 'Selesai'?'fa-check-circle':''}}"></i>
                                <i onclick="showModal('{{$item->id}}')" class="fas fa-trash text-danger"></i>
                            </span>
                        </div>
                        </div>
                    @endforeach
                  </div>
            </div>
        </div>
        <div class="col-sm-1"></div>
        <div class="col-sm-6">
            @yield('content')
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="modalDelete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Hapus Tugas</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Hapus tugas "<span id="textModal"></span>"</p>
              <input type="hidden" id="task_id">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <a href="#" onclick="taskDelete()" id="buttonDelete" class="btn btn-danger">Hapus</a>
            </div>
          </div>
        </div>
      </div>
    <script>
        function showModal(id){
            $('#modalDelete').modal('show');
            $.ajax({
                type: "GET",
                url: "{{asset('user/task/get?task_id=')}}"+id,
                data: {
                    'task_id':id,
                },
                success: function(data){
                    $('#textModal').text(data['name']);
                    $('#task_id').val(data['id']);
                },
            });
        }
        
        function taskDelete(){
            var task_id = $('#task_id').val();
            $.ajax({
                type: "PUT",
                url: "{{asset('user/task/delete')}}",
                data: {
                    'task_id':task_id,
                    "_method": 'DELETE',
                    "_token": "{{csrf_token()}}",
                },
                success: function(data){
                    $('#modalDelete').modal('hide');
                    $('#menu'+data['task_id']).remove();
                    if ({{$task->id??0}} == data['task_id']) {
                        location.reload();
                    }
                },
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>