@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Category </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{route('catagory.store')}}" class="forms-sample">
                                @csrf

                                <div class="form-group">
                                    <label for="catagoryName">Name</label>
                                    <input value="{{old('catagoryName')}}" type="txt" class="form-control" name="catagoryName" id="catagoryName" placeholder="Category Name">
                                    <small  class="form-text" style="color: red">{{$errors->first('catagoryName')}}</small>
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
