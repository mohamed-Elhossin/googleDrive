@extends('layouts.app')



@section('content')
    <h1 class="text-center my-3 text-info"> This page show only for Admin </h1>

    <div class="container col-md-6">


        @if (Session::has('done'))
            <div class="alert alert-success">
                {{ Session::get('done') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card p-4">
            <div class="card-body">
                <table class="table table-dark">
                    <tr>
                        <th>No </th>
                        <th> Title </th>
                        <th> Status </th>
                        <th colspan="3">Action</th>
                    </tr>
                    @foreach ($drives as $item)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th> {{ $item->title }} </th>
                            <th>
                                @if ($item->status == 'private')
                                    <a href="{{ route('drive.changeStatus', $item->id) }}"><i title="Make it Public"
                                            class="text-danger fa-solid fa-lock"></i></a>
                                @else
                                    <a href="{{ route('drive.changeStatus', $item->id) }}"> <i title="Make It private"
                                            class="text-success fa-solid fa-lock-open"></i>
                                    </a>
                                @endif

                            </th>
                            <th> <a href="{{ route('drive.show', $item->id) }}"><i class="  fa-solid fa-eye"
                                        title="show Drive"></i></a> </th>
                            <th><a href="{{ route('drive.edit', $item->id) }}"><i
                                        class="text-warning fa-solid fa-pen-to-square" title="Edit"></i></a></th>
                            <th> <a href="{{ route('drive.destroy', $item->id) }}"><i title="Remove"
                                        class="text-danger fa-solid fa-trash-can"></i>
                                </a> </th>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
