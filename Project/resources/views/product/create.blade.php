
@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Product </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{route('product.store')}}" class="forms-sample">
                                @csrf
                                <div class="form-group">
                                    <label for="barcode">Barcode</label>
                                    <input value="{{old('barcode')}}" type="text" class="form-control" id="barcode" name="barcode" placeholder="Product Barcode">
                                    <small  class="form-text" style="color: red">{{$errors->first('barcode')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="productName">Product Name</label>
                                    <input value="{{old('productName')}}" type="txt" class="form-control" name="productName" id="productName" placeholder="Product Name">
                                    <small  class="form-text" style="color: red">{{$errors->first('productName')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="sellingPrice">Selling Price</label>
                                    <input value="{{old('sellingPrice')}}" type="number" step="0.01" class="form-control" name="sellingPrice" id="sellingPrice">
                                    <small  class="form-text" style="color: red">{{$errors->first('sellingPrice')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="purcashingPrice">Purcashing Price</label>
                                    <input value="{{old('purcashingPrice')}}" type="number" step="0.01" class="form-control" name="purcashingPrice" id="purcashingPrice">
                                    <small  class="form-text" style="color: red">{{$errors->first('purcashingPrice')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input value="{{old('stock')}}" type="number" class="form-control" name="stock" id="stock">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select name="catagoryID" class="form-control">
                                        <option value="" disabled selected>Select Category</option>
                                        @forelse ($catagories as $catagory)
                                            <option @if (old('catagoryID') == $catagory->catagoryID) @selected(true)
                                            @endif value="{{$catagory->catagoryID}}">{{$catagory->catagoryName}}</option>
                                        @empty
                                            <option value=""disabled selected>No Categories</option>
                                        @endforelse

                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('catagoryID')}}</small>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    <select name="companyID" class="form-control">
                                        <option  disabled selected>Select Category</option>

                                        @forelse ($companies as $company)
                                            <option @if (old('companyID') == $company->companyID) @selected(true)
                                            @endif value="{{$company->companyID}}">{{$company->companyName}}</option>
                                        @empty
                                            <option disabled selected>No Companies</option>
                                        @endforelse

                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('companyID')}}</small>
                                </div>
                                <button type="submit" value="save" name="save" class="btn btn-primary me-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
