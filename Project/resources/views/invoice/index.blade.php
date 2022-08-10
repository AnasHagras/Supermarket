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
            <h3 class="page-title"> Invoices </h3>
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
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder="Invoice ID" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>invoiceId</th>
                                        <th>invoicePrice</th>
                                        <th>Total Items</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $invoice)
                                    <tr>
                                        <td>{{$invoice->invoiceID}}</td>
                                        <td>{{$invoice->invoicePrice}}</td>
                                        <td>{{$invoice->itemCounter}}</td>
                                        <td>{{$invoice->invoiceDate}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{route ('invoice.show',$invoice->invoiceID)}}">Show</a></label>
                                            <form action="{{route('invoice.destroy',$invoice->invoiceID)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td align="center" colspan="3">No Data</td>
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
    const tableName = "invoices";
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
                type: 8,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['status']);
                if (response['status'] == 200) {
                    invoices = JSON.parse(response['invoices']);
                    document.querySelector("tbody").innerHTML = "";
                    invoices.forEach(function(invoice) {
                        tr = document.createElement("tr");
                        invoiceIDTD = document.createElement("td");
                        invociePriceTD = document.createElement("td");
                        totatItemsTD = document.createElement("td");
                        dateTD = document.createElement("td");
                        actionTD = document.createElement("td");
                        invoiceIDTD.innerHTML = invoice['invoiceID'];
                        invociePriceTD.innerHTML = invoice['invoicePrice'];
                        totatItemsTD.innerHTML = invoice['itemCounter'];
                        dateTD.innerHTML = invoice['invoiceDate'];

                        tr.appendChild(invoiceIDTD);
                        tr.appendChild(invociePriceTD);
                        tr.appendChild(totatItemsTD);
                        tr.appendChild(dateTD);
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
