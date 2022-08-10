@extends('layouts.master')
@section('content')
<style>
    a{
        text-decoration: none;
        color: white;
    }
    a:hover{
        color: white;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Incomings </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>IncomingID</th>
                                        <th>Cost</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $incoming)
                                    <tr>
                                        <td>{{$incoming->incomingID}}</td>
                                        <td>{{$incoming->cost}}</td>
                                        <td>{{$incoming->desc}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{ route('incoming.show',$incoming->incomingID) }}">Show</a></label>
                                            <form action= "{{route('incoming.destroy',$incoming->incomingID)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>

                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td align="center" colspan="3">No Data</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
