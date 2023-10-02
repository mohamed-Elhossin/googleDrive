@extends('layouts.app')



@section('content')
    <h1 class="text-center my-3 text-info"> List All Public Drives </h1>

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
                        <th>Auther</th>
                        <th colspan="3">Action</th>
                    </tr>
                    @forelse ($drives as $item)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th> {{ $item->title }} </th>
                            <th> {{ $item->name }}</th>
                            <th> <a href="{{ route('drive.show', $item->driveId) }}"><i class="  fa-solid fa-eye"
                                        title="show Drive"></i></a> </th>
                        </tr>
                    @empty
                        <h1 class="text-danger text-center"> No Find Any Drive Public</h1>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
@endsection
