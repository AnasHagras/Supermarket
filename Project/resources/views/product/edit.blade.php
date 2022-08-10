@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Product details</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('msg'))
                        <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <div class="form-responsive">
                            <form method="POST" action="{{ route('product.update',$data->barcode) }}" class="forms-sample">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Product Barcode" value='{{ old('barcode', $data->barcode) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('barcode')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="productName">Product Name</label>
                                    <input type="txt" class="form-control" name="productName" id="productName" placeholder="Product Name" value='{{ old('productName',$data->productName) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('productName')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="sellingPrice">Selling Price</label>
                                    <input type="number" step="0.01" class="form-control" name="sellingPrice" id="sellingPrice" value='{{ old('sellingPrice',$data->sellingPrice) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('sellingPrice')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="purcashingPrice">Purcashing Price</label>
                                    <input type="number" step="0.01" class="form-control" name="purcashingPrice" id="purcashingPrice" value='{{old('purcashingPrice',$data->purcashingPrice) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('purcashingPrice')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="stock">Stock</label>
                                    <input type="number" class="form-control" name="stock" id="stock" value='{{ old('stock',$data->stock)}}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('stock')}}</small>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Category</label>
                                    <select name="catagoryID" class="form-control">
                                        <option value="" disabled selected>Select Category</option>
                                        @forelse ($catagories as $catagory)
                                        <option value="{{$catagory->catagoryID}}" <?php if ($catagory->catagoryID == $data->catagoryID || old('catagoryID') == $data->catagoryID ) echo "selected" ?>>{{$catagory->catagoryName}}</option>
                                        @empty
                                        <option value="" disabled selected>No Categories</option>
                                        @endforelse

                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('catagoryID')}}</small>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Company</label>
                                    <select name="companyID" class="form-control">
                                        <option value="" disabled selected>Select Company</option>

                                        @forelse ($companies as $company)
                                        <option value="{{$company->companyID}}" @if($company->companyID==$data->companyID || old('companyID') == $data->companyID)
                                            {{'selected'}}
                                            @endif
                                            >
                                            {{$company->companyName}}
                                        </option>
                                        @empty
                                        <option value="" disabled selected>No Companies</option>
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
