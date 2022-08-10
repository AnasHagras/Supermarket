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
            <h3 class="page-title"> Category Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Category ID</th>
                                        <td>{{$data->catagoryID}}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{$data->catagoryName}}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                    <a href="" class="btn btn-primary">Edit</a>
                                </div>
                                <form action="{{route('catagory.destroy',$data->catagoryID)}}" method="POST" style="display:inline">
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Barcode</th>
                                    <th>Product Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                <tr>
                                    <td>{{$product->barcode}}</td>
                                    <td>{{$product->productName}}</td>
                                    <td>
                                        <label class="badge badge-success"><a href=" {{ route('product.show',$product->barcode) }}">Show</a></label>
                                        <label class="badge badge-warning"><a href="{{ route('product.edit',$product->barcode) }}">Edit</a></label>
                                        <form action="{{route('product.destroy',$product->barcode)}}" method="POST" style="display:inline">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                            <!-- <label class="badge badge-danger"><a href="{{route('product.destroy',$product->barcode)}}">Delete</a></label> -->
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td align="center" colspan="2">No Data</td>
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