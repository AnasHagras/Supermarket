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
            <h3 class="page-title"> Outgoing </h3>
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
                                        <th>OutgoingID</th>
                                        <th>Cost</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $outgoing)
                                    <tr>
                                        <td>{{$outgoing->outgoingID}}</td>
                                        <td>{{$outgoing->cost}}</td>
                                        <td>{{$outgoing->desc}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{ route('outgoing.show',$outgoing->outgoingID) }}">Show</a></label>

                                            <form action= "{{route('outgoing.destroy',$outgoing->outgoingID)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>

                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td align="center" colspan="4">No Data</td>
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
