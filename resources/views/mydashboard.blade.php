@extends('layouts.master') @section('content')
<div class="main-panel">
    @if (Session::has('msg'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Not Allowed</strong> {{ Session::get('msg') }}
        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
    @endif
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Revenue</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div
                                    class="d-flex d-sm-block d-md-flex align-items-center"
                                >
                                    <h2  @if($incoming-$outgoing < 0) style="color: red" @else style="color: green"  @endif class="mb-0">{{$incoming-$outgoing}} EGP</h2>

                                </div>
                                <h6 class="text-muted font-weight-normal">

                                </h6>
                            </div>
                            <div
                                class="col-4 col-sm-12 col-xl-4 text-center text-xl-right"
                            >
                                <i
                                    class="icon-lg mdi mdi-codepen text-primary ms-auto"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Incomings</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div
                                    class="d-flex d-sm-block d-md-flex align-items-center"
                                >
                                    <h2 class="mb-0">{{$incoming}} EGP</h2>

                                </div>

                            </div>
                            <div
                                class="col-4 col-sm-12 col-xl-4 text-center text-xl-right"
                            >
                                <i
                                    class="icon-lg mdi mdi-wallet-travel text-danger ms-auto"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Outgoings</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div
                                    class="d-flex d-sm-block d-md-flex align-items-center"
                                >
                                    <h2 class="mb-0">{{$outgoing}} EGP</h2>

                                </div>

                            </div>
                            <div
                                class="col-4 col-sm-12 col-xl-4 text-center text-xl-right"
                            >
                                <i
                                    class="icon-lg mdi mdi-monitor text-success ms-auto"
                                ></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center row">

            <div class="col-sm-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Total Products</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div
                                    class="d-flex d-sm-block d-md-flex align-items-center"
                                >
                                    <h2 class="mb-0">{{$products}} Prouct, Divided into {{$categories}} category</h2>

                                </div>
                                <h6 class="text-muted font-weight-normal">
                                    More products comming soon
                                </h6>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex justify-content-center row">

            <div class="col-sm-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h5>Supplier Companies</h5>
                        <div class="row">
                            <div class="col-8 col-sm-12 col-xl-8 my-auto">
                                <div
                                    class="d-flex d-sm-block d-md-flex align-items-center"
                                >
                                    <h2 class="mb-0">We have {{$companies}} supplier company</h2>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endsection
</div>
