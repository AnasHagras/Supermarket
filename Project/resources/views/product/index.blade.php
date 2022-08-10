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
            <h3 class="page-title"> Products </h3>
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
                                        <th>Barcode</th>
                                        <th>ProcuctName</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $product)
                                    <tr>
                                        <td>{{$product->barcode}}</td>
                                        <td>{{$product->productName}}</td>
                                        <td>{{$product->sellingPrice}}</td>
                                        <td>{{$product->stock}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href=" {{ route('product.show',$product->barcode) }}">Show</a></label>
                                            <label class="badge badge-warning"><a href="{{ route('product.edit',$product->barcode) }}">Edit</a></label>
                                            <form action= "{{route('product.destroy',$product->barcode)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                                <!-- <label class="badge badge-danger"><a href="{{route('product.destroy',$product->barcode)}}">Delete</a></label> -->
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td align="center" colspan="5">No Data</td>
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
