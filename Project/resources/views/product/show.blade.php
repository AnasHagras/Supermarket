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
            <h3 class="page-title"> Product Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product barcode</th>
                                        <td>{{$data->barcode}}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{$data->productName}}</td>
                                    </tr>
                                    <tr>
                                        <th>sellingPrice</th>
                                        <td>{{$data->sellingPrice}}</td>
                                    </tr>
                                    <tr>
                                        <th>purcashingPrice</th>
                                        <td>{{$data->purcashingPrice}}</td>
                                    </tr>
                                    <tr>
                                        <th>stock</th>
                                        <td>{{$data->stock}}</td>
                                    </tr>
                                    <tr>
                                        <th>Catagory</th>
                                        <td><a href="{{route('catagory.show',$data->catagoryID)}}">{{$data->catagoryName}}</a></td>
                                    </tr>
                                    <tr>
                                        <th>Company</th>
                                        <td><a href="{{route('company.show',$data->companyID)}}">{{$data->companyName}}</a></td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                    <a href="{{ route('product.edit',$data->barcode) }}" class="btn btn-primary">Edit</a>
                                </div>
                                <form action=" {{ route('product.destroy',$data->barcode) }}" method="POST" style="display:inline">
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