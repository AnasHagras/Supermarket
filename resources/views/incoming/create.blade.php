@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Incoming</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-responsive">
                            <form method="POST" action="{{route('incoming.store')}}" class="forms-sample" autocomplete='off'>
                                @csrf
                                <div class="form-group">
                                    <label for="cost">Cost</label>
                                    <input value="{{ old('cost') }}" type="number" class="form-control" name="cost" id="cost" placeholder="cost" value="" autocomplete="off">
                                    <small class="form-text" style="color: red">{{$errors->first('cost')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <input value="{{ old('desc') }}" type="text" class="form-control" name="desc" id="desc" placeholder="Desc">
                                    <small class="form-text" style="color: red">{{$errors->first('desc')}}</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Reason</label>
                                    <select style="color: white" name="reason" class="form-control">
                                        <option value="" disabled selected>Select Reason</option>
                                        <option value="Tip">{{ 'Tip' }}</option>
                                        <option value="Order">{{ 'Order' }}</option>
                                        <option value="Extra">{{ 'Extra' }}</option>
                                    </select>
                                    <small class="form-text" style="color: red">{{$errors->first('reason')}}</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">User</label>
                                    <select style="color: white" name="userID" class="form-control">
                                        <option value="" disabled selected>Select User</option>
                                        @forelse ($users as $user)
                                        <option value="{{$user->userID}}"> {{$user->name }}</option>
                                        @empty
                                        <option value="" disabled selected>No Users</option>
                                        @endforelse
                                    </select>
                                    <small class="form-text" style="color: red">{{$errors->first('user')}}</small>
                                </div>
                                <button type="submit" value="save" name="save" class="btn btn-primary me-2">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection