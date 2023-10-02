@extends('layouts.app')



@section('content')
    <h1 class="text-center my-3 text-info"> Show Drives: {{ $drive->id }} </h1>

    <div class="container col-md-4">


        @if (Session::has('done'))
            <div class="alert alert-success">
                {{ Session::get('done') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            @if (
                $drive->extension == 'JPG' ||
                    $drive->extension == 'PNG' ||
                    $drive->extension == 'GIF' ||
                    $drive->extension == 'jfif')
                <img src="{{ asset("upload/drives/$drive->file") }}" class="img-fluid" alt="">
            @else
                <img src="{{ asset('img/folder.webp') }}" class="img-fluid" alt="">
            @endif
            <div class="card-body mt-2">
                <h6>Title : {{ $drive->title }} </h6>
                <hr>
                <h6>Description : {{ $drive->description }} </h6>
                <hr>
                <h6>Extension : {{ $drive->extension }} </h6>
                <hr>
                <div class="d-grid">
                    <a href="{{ route('drive.download', $drive->id) }}" class="btn btn-success"> Download</a>
                </div>
            </div>
        </div>
    </div>
@endsection
