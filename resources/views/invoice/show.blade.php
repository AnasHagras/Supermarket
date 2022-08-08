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
            <h3 class="page-title"> Invoice Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>invoiceID</th>
                                        <td>{{$data->invoiceID}}</td>
                                    </tr>
                                    <tr>
                                        <th>invoice Price</th>
                                        <td>{{$data->invoicePrice}}</td>
                                    </tr>
                                    <tr>
                                        <th>Item Count</th>
                                        <td>{{$data->itemCounter}}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{$data->invoiceDate}}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td><a href="{{route('user.show',$userID)}}">{{$username}}</a></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!-- onther table for products in that reciept -->
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                </div>
                                <form action=" {{ route('invoice.destroy',$data->invoiceID) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product Barcode</th>
                                        <th>Product Name</th>
                                        <th>Count</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $item)
                                    <tr>
                                        <td>{{$item->barcode}}</td>
                                        <td>{{$item->productName}}</td>
                                        <td>{{$item->itemCounter}}</td>
                                        <td>{{$item->sellingPrice}}</td>
                                        <td>{{$item->itemTotalPrice	}}</td>
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
