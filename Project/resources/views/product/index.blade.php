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
                        <form style="display: flex;" method="POST" action="" class="searchForm" autocomplete='off'>
                            @csrf
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder="Product Name" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
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
<script>
    const tableName = "products";
    const form = document.querySelector(".searchForm");
    const submit = document.querySelector(".submitButton");
    // console.log(submit);
    submit.addEventListener('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/ajaxRequest",
            type: "POST",
            data: {
                searchText: document.querySelector(".searchText").value,
                tableName: tableName,
                type: 7,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['status']);
                if (response['status'] == 200) {
                    products = JSON.parse(response['products']);
                    document.querySelector("tbody").innerHTML = "";
                    products.forEach(function(product) {
                        tr = document.createElement("tr");
                        barcodTD = document.createElement("td");
                        productNameTD = document.createElement("td");
                        priceTD = document.createElement("td");
                        stockTD = document.createElement("td");
                        barcodTD.innerHTML = product['barcode'];
                        productNameTD.innerHTML = product['productName'];
                        priceTD.innerHTML = product['sellingPrice'];
                        stockTD.innerHTML = product['stock'];
                        actionTD = document.createElement("td")

                        tr.appendChild(barcodTD);
                        tr.appendChild(productNameTD);
                        tr.appendChild(priceTD);
                        tr.appendChild(stockTD);
                        tr.appendChild(actionTD);
                        document.querySelector("tbody").appendChild(tr);
                    });
                } else {
                    document.querySelector("tbody").innerHTML = "";
                    tr = document.createElement("tr");
                    td = document.createElement("td");
                    td.innerHTML = response['msg'];
                    tr.appendChild(td);
                    document.querySelector("tbody").appendChild(tr);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
@endsection
