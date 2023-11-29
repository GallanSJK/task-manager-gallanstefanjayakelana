@extends('user.template')
@section('content')
    <div class="d-flex justify-content-between mt-4">
        <div>
            <h2 class="fw-bold">{{ $task->name }} <a href="{{ asset('user/task/update/'.$task->id) }}"><i class="fas fa-edit text-primary"></i></a></h2>
        </div>
        <div>
            <label class="form-check-label ms-3 btn fw-bold {{ $task->status=="Selesai"?'btn-success':'btn-danger' }}" id="status" onclick="showModalStatus('{{$task->id}}')" for="flexSwitchCheckChecked">{{ $task->status }}</label>
        </div>
    </div>
    @if ($task->file)
        <img src="{{ asset('image/'.$task->file) }}" alt="" class="img-fluid">
    @endif
    <p>{!! $task->description !!}</p>

    <div class="modal fade" tabindex="-1" id="modalStatus">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Tandai tugas menjadi "<span id="textStatus"></span>"</p>
              <input type="hidden" id="status_task_id">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <a href="#" onclick="changeStatus()" id="buttonDelete" class="btn btn-primary">Tandai</a>
            </div>
          </div>
        </div>
      </div>

      <script>
        function showModalStatus(id){
            $('#modalStatus').modal('show');
            $.ajax({
                type: "GET",
                url: "{{asset('user/task/get?task_id=')}}"+id,
                data: {
                    'task_id':id,
                },
                success: function(data){
                    var text;
                    if (data['status'] == "Belum Selesai") {
                        text = 'Selesai';
                    }else{
                        text = 'Belum Selesai';
                    }
                    $('#textStatus').text(text);
                    $('#status_task_id').val(data['id']);
                },
            });
        }

            function changeStatus(){
            var task_id = $('#status_task_id').val();
            $.ajax({
                type: "PUT",
                url: "{{asset('user/task/status')}}",
                data: {
                    'task_id':task_id,
                    "_method": 'PUT',
                    "_token": "{{csrf_token()}}",
                },
                success: function(data){
                    $('#modalStatus').modal('hide');
                    $('#status').text(data['status']);
                    if (data['status'] == "Selesai") {
                        $('#status').addClass('btn-success');
                        $('#status').removeClass('btn-primary');
                        $('#check'+data['id']).addClass('fa-check-circle');
                    }else{
                        $('#check'+data['id']).removeClass('fa-check-circle');
                        $('#status').removeClass('btn-success');
                        $('#status').addClass('btn-primary');
                    }
                },
            });
        }
      </script>
    
@endsection