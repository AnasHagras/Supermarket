
@extends('layouts.master')
@section('content')
<style>
    a {
        text-decoration: none;
        color: white;
    }

    a:hover {
        color: green !important;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Incoming Info </h3>
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
                                        <td>{{$data->incomingID??""}}</td>
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
                                        <th>Date</th>
                                        <td>{{$data->date??""}}</td>
                                    </tr>
                                    <tr>
                                        <th>Reason</th>
                                        <td>{{$data->reason??""}}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td><a href="{{route('user.show',$data['userID'])}}">{{$username??""}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Invoice</th>
                                        @if($data['invoiceID'])
                                            <td><a href="{{route('invoice.show',$data['invoiceID'])}}">{{$data['invoiceID']}}</a></td>
                                        @else
                                            <td>Not Available</td>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                    <a href="{{route('incoming.edit',$data->incomingID)}}" class="btn btn-primary">Edit</a>
                                </div>
                                <form action="{{route('incoming.destroy',$data->incomingID)}}" method="POST" style="display:inline">
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
