@extends('layouts.app')



@section('content')
    <h1 class="text-center my-3 text-info"> Upload Drive </h1>

    <div class="container col-md-6">
        {{--
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
        @if (Session::has('done'))
            <div class="alert alert-success">
                {{ Session::get('done') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4">
            <div class="card-body">
                <form action="{{ route('drive.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group">
                        <label for="">Drive Title </label>
                        <input type="text" name="title" class="form-control  @error('title')  is-invalid  @enderror  ">

                        @error('title')
                            <span class="text-danger">هذا الحقل مطلوب</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""> Drive Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Upload Your File </label>
                        <input type="file" name="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Category </label>
                        <select class="form-control" name="category" id="">
                            @foreach ($category as $item)
                                <option value="{{ $item->id }}"> {{ $item->title }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-grpup">
                        <div class="d-grid"> <button class="btn  btn-info"> Upload Now </button></div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
