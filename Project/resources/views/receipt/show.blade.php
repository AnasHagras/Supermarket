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
            <h3 class="page-title"> Receipt Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ReceiptID</th>
                                        <td>{{$data->receiptID}}</td>
                                    </tr>
                                    <tr>
                                        <th>Receipt Price</th>
                                        <td>{{$data->receiptPrice}}</td>
                                    </tr>
                                    <tr>
                                        <th>Item Count</th>
                                        <td>{{$data->itemCounter}}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{$data->receiptDate}}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td><a href="{{route('user.show',$userID)}}">{{$username}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Company</th>
                                        <td><a href="{{route('company.show',$companyID)}}">{{$companyName}}</a></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!-- onther table for products in that reciept -->
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                </div>
                                <form action=" {{ route('receipt.destroy',$data->receiptID) }}" method="POST" style="display:inline">
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