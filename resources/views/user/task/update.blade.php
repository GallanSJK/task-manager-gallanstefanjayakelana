@extends('user.template')
@section('content')
<p class="mt-4 green-primary text-white p-2 fw-bold label-book">Sunting Tugas</p>
<form action="{{ asset('user/task/edit') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $data->id }}">
    <input type="text" name="name" value="{{ $data->name }}" id="name" class="input-form" placeholder="Judul">
    @if($errors->has('name'))
        <small class="text-danger">{{ $errors->first('name') }}</small>
    @endif
    <div class="mt-3"></div>
    <textarea name="description" id="content" class="area-form" placeholder="Description" rows="5">{{$data->description }}</textarea>
    <img src="{{ asset('image/'.$data->file) }}" id="preview" alt="" class="w-25 mt-3">
    <input type="file" name="file" id="file" onchange="previewFile(this);" class="form-control mt-3" placeholder="Judul">
    @if($errors->has('file'))
        <small class="text-danger">{{ $errors->first('file') }}</small>
        <br>
    @endif
    <button class="btn btn-success mt-3" type="submit">Perbarui</button>
</form>

<script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#preview").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
</script>

<script>
    ClassicEditor
    .create( document.querySelector( '#content' ), {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
            ],
        },
    } )
    .catch( error => {
        console.log( error );
    } );
</script>
@endsection