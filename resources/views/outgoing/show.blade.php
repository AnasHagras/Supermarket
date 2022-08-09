
@extends('layouts.master')
@section('content')
<style>
    a {
        text-decoration: none;
        color: white;
    }

    a:hover {
        color: white;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Outgoing Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div  class="table-responsive">
                            <table  class="table">
                                <thead>
                                    <tr>
                                        <th>incoming ID</th>
                                        <td>{{$data->outgoingID??""}}</td>
                                    </tr>
                                    <tr>
                                        <th>Cost</th>
                                        <td>{{$data->cost??""}}</td>
                                    </tr>
                                    <tr>
                                        <th>Desc</th>
                                        <td>{{$data->desc??""}}</td>
                                    </tr>
                                    <tr>
                                        <th>Reason</th>
                                        <td>{{$data->reason??""}}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{$username??""}}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">

                                <form action="{{route('outgoing.destroy',$data->outgoingID)}}" method="POST" style="display:inline">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
