@extends('user.template')
@section('content')
    <p class="mt-4 green-primary text-white p-2 fw-bold label-book">Buat Tugas Baru</p>
    <form action="{{ asset('user/task/store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name" id="name" class="input-form" placeholder="Judul">
        @if($errors->has('name'))
            <small class="text-danger">{{ $errors->first('name') }}</small>
        @endif
        <div class="mt-3"></div>
        <textarea name="description" id="content" class="area-form" placeholder="Description" rows="5">{{ old('description') }}</textarea>
        <input type="file" name="file" id="file" class="form-control mt-3" placeholder="Judul">
        @if($errors->has('file'))
            <small class="text-danger">{{ $errors->first('file') }}</small>
            <br>
        @endif
        <button class="btn btn-success mt-3" type="submit">Buat Tugas</button>
    </form>
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