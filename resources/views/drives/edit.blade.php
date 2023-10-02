@extends('layouts.app')



@section('content')
    <h1 class="text-center my-3 text-info"> Edit Drive : {{$drive->driveId }} </h1>

    <div class="container col-md-6">


        @if (Session::has('done'))
            <div class="alert alert-success">
                {{ Session::get('done') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4">
            <div class="card-body">
                <form action="{{ route('drive.update' ,$drive->driveId ) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="">Drive Title </label>
                        <input type="text"  value="{{$drive->driveTitle}}" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for=""> Drive Description</label>
                        <input type="text" value="{{$drive->description}}" name="description" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Upload Your File : {{$drive->file}} </label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Category </label>
                        <select class="form-control" name="category" id="">
                            <option  value="{{$drive->driveCategoryId}}">  {{$drive->categoryTitle}} </option>
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-grpup">
                        <div class="d-grid"> <button class="btn  btn-info"> Edit File  </button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
