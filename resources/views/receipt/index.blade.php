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
            <h3 class="page-title"> Receipts </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('msg'))
                        <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ReceiptId</th>
                                        <th>ReciptPrice</th>
                                        <th>Total Items</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $receipt)
                                    <tr>
                                        <td>{{$receipt->receiptID}}</td>
                                        <td>{{$receipt->receiptPrice}}</td>
                                        <td>{{$receipt->itemCounter}}</td>
                                        <td>{{$receipt->receiptDate}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{route ('receipt.show',$receipt->receiptID)}}">Show</a></label>
                                            <form action="{{route('receipt.destroy',$receipt->receiptID)}}" method="POST" style="display:inline">
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