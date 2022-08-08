@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Category details</h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('msg'))
                        <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <div class="form-responsive">
                            <form method="POST" action="{{ route('catagory.update',$data->catagoryID) }}" class="forms-sample">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="catagoryName">Name</label>
                                    <input type="text" class="form-control" id="catagoryName" name="catagoryName" placeholder="Category Name" value='{{old('catagoryName',$data->catagoryName) }}'>
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
