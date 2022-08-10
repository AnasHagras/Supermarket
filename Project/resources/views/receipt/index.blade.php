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
            <h3 class="page-title"> Receipts </h3>
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
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder="Receipt ID" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ReceiptId</th>
                                        <th>ReciptPrice</th>
                                        <th>Total Items</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $receipt)
                                    <tr>
                                        <td>{{$receipt->receiptID}}</td>
                                        <td>{{$receipt->receiptPrice}}</td>
                                        <td>{{$receipt->itemCounter}}</td>
                                        <td>{{$receipt->receiptDate}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{route ('receipt.show',$receipt->receiptID)}}">Show</a></label>
                                            <form action="{{route('receipt.destroy',$receipt->receiptID)}}" method="POST" style="display:inline">
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
    const tableName = "receipts";
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
                type: 11,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['status']);
                if (response['status'] == 200) {
                    receipts = JSON.parse(response['receipts']);
                    document.querySelector("tbody").innerHTML = "";
                    receipts.forEach(function(receipt) {
                        tr = document.createElement("tr");
                        receiptsIDTD = document.createElement("td");
                        receiptsPriceTD = document.createElement("td");
                        totatItemsTD = document.createElement("td");
                        dateTD = document.createElement("td");
                        actionTD = document.createElement("td");
                        receiptsIDTD.innerHTML = receipt['receiptID'];
                        receiptsPriceTD.innerHTML = receipt['receiptPrice'];
                        totatItemsTD.innerHTML = receipt['itemCounter'];
                        dateTD.innerHTML = receipt['receiptDate'];

                        tr.appendChild(receiptsIDTD);
                        tr.appendChild(receiptsPriceTD);
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
