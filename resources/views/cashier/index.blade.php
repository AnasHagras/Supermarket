@extends('layouts.master')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('content')
<style>
    a {
        text-decoration: none;
        color: black;
    }

    a:hover {
        color: green !important;
    }

    .removeButton:hover {
        cursor: pointer;
        color: red;
    }

    .active {
        display: block !important;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Cashier </h3>
        </div>

        <div class="row">

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">

                    <div class="card-body">
                        <div class="alert alert-success msg" style="display: none;"></div>
                        <form style="display: flex;" method="POST" action="" class="cashierForm" autocomplete='off'>
                            @csrf
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control" name="barcode" id="name" placeholder="barcode" style="margin-right:10px !important">
                            </div>
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control" name="count" id="count" placeholder="count" value="" autocomplete="off">
                            </div>
                            <button type="submit" value="save" name="save" class="btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Add</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>barcode</th>
                                        <th>productName</th>
                                        <th>price</th>
                                        <th>count</th>
                                        <th>total</th>
                                        <th>action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Session::has('invoiceItems'))
                                    @foreach(Session::get('invoiceItems') as $product)
                                    <tr>
                                        <td name="barcode" value="{{$product['barcode']}}">{{$product['barcode']}}</td>
                                        <td name='productName' value="{{$product['productName']}}">{{$product['productName']}}</td>
                                        <td name="price" value="{{$product['sellingPrice']}}">{{$product['sellingPrice']}}</td>
                                        <td name="count" value="{{$product['count']}}">{{$product['count']}}</td>
                                        <td name="total" value="{{$product['itemTotalPrice']}}">{{$product['itemTotalPrice']}}</td>
                                        <td class="removeButton" value="{{$product['barcode']}}">Remove</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div>Item Count : <span id="itemCount"></span></div>
                            <div>Total Price : <span id="totalSpan"></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 grid-margin stretch-card" style="margin-top: 20px;">
                                <div class="card">
                                    <button class="btn btn-primary me-2" id="cash">Cash</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    let cashForm = document.querySelector(".cashierForm");
    let tbody = document.querySelector("table tbody");
    let totalSpan = document.querySelector("#totalSpan");
    let cc = document.querySelector("#itemCount");
    let cash = document.querySelector("#cash");
    updateAll();
    [...document.querySelectorAll(".removeButton")].forEach(function($btn) {
        $btn.addEventListener('click', function(e) {
            removeFromTable($btn.getAttribute("value"));
        })
    });
    cash.addEventListener('click', function() {
        // let currentPrice = $("input[name=price]").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        total = document.querySelector("#totalSpan").innerText;
        counter = document.querySelector("#itemCount").innerText;
        data = convertTrToArray();
        $.ajax({
            url: "invoice",
            type: "POST",
            data: {
                data: data,
                totalPrice: total,
                itemCount: counter,
                _token: _token
            },
            success: function(response) {
                if (response['status'] == 200) {
                    tbody.innerHTML = "";
                    updateAll();
                    document.querySelector("input[name=barcode]").value = "";
                    document.querySelector("input[name=count]").value = "";
                    showSuccessMessage(response['msg']);
                    $.ajax({
                        url: "/ajaxRequest",
                        type: "POST",
                        data: {
                            type: 2,
                            _token: _token
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    showErrorMessage(response['msg']);
                }
            },
            error: function(error) {
                // console.log(error);
                showErrorMessage("Internal Error!");

            }
        });
    });
    cashForm.addEventListener('submit', function(e) {
        // console.log("F");
        e.preventDefault();
        let barcode = $("input[name=barcode]").val();
        let initialCount = $("input[name=count]").val();
        let count = getCurrentCount(barcode, parseInt($("input[name=count]").val()));
        // let currentPrice = $("input[name=price]").val();
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "/ajaxRequest", // send request to product 
            type: "POST",
            data: {
                barcode: barcode,
                count: count,
                type: 0,
                _token: _token
            },
            success: function(response) {
                if (response['status'] == 200) {
                    const product = JSON.parse(response['product']);
                    if (!itemExists(product['barcode'], count, product['sellingPrice'])) {
                        addItem(product, barcode, count);
                    } else {
                        updateItem(barcode, initialCount, product['sellingPrice']);
                    }
                    sendUpdateSessionRequest();
                    updateAll();
                    removeMessage();
                } else {
                    showErrorMessage(response['msg']);
                    // will be one of these >> cannot be null >> barcode not found >> count is not available
                }
            },
            error: function(error) {
                showErrorMessage(error);
                // handle errors here
            }
        });
    });

    function sendUpdateSessionRequest() {
        $.ajax({
            url: "/ajaxRequest", // send request to product 
            type: "POST",
            data: {
                toBeSaved: convertTrToArray(),
                type: 1,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function removeMessage() {
        document.querySelector(".msg").innerHTML = "";
        document.querySelector(".msg").classList.remove("active");
    }

    function showSuccessMessage(message) {
        document.querySelector(".msg").innerHTML = message;
        document.querySelector(".msg").classList.add("alert-success");
        document.querySelector(".msg").classList.remove("alert-danger");
        document.querySelector(".msg").classList.add("active");
    }

    function showErrorMessage(message) {
        document.querySelector(".msg").innerHTML = message;
        document.querySelector(".msg").classList.remove("alert-success");
        document.querySelector(".msg").classList.add("alert-danger");
        document.querySelector(".msg").classList.add("active");
    }

    function addItem(product, barcode, count) {
        const tr = document.createElement("tr");
        const barcodeTD = document.createElement("td");
        const productNameTD = document.createElement("td");
        const priceTD = document.createElement("td");
        const countTD = document.createElement("td");
        const totalTD = document.createElement("td");
        const removeTD = document.createElement("td");
        barcodeTD.setAttribute("name", 'barcode');
        barcodeTD.setAttribute("value", barcode);
        productNameTD.setAttribute("name", "productName");
        productNameTD.setAttribute("value", product['productName']);
        priceTD.setAttribute("name", "price");
        priceTD.setAttribute("value", product['sellingPrice']);
        countTD.setAttribute("name", "count");
        countTD.setAttribute("value", count);
        totalTD.setAttribute("name", "total");
        totalTD.setAttribute("value", product['sellingPrice'] * count);
        barcodeTD.innerText = product['barcode'];
        productNameTD.innerText = product['productName'];
        priceTD.innerText = product['sellingPrice'];
        countTD.innerText = count;
        totalTD.innerText = product['sellingPrice'] * count;
        removeTD.innerText = "Remove";
        removeTD.setAttribute("value", product['barcode']);
        removeTD.classList.add("removeButton");
        tr.appendChild(barcodeTD);
        tr.appendChild(productNameTD);
        tr.appendChild(priceTD);
        tr.appendChild(countTD);
        tr.appendChild(totalTD);
        tr.appendChild(removeTD);
        tbody.appendChild(tr);
    }

    function convertTrToArray() {
        $trs = tbody.querySelectorAll("tr");
        $products = [];
        [...$trs].forEach(function($tr) {
            $barcode = $tr.querySelector("[name=barcode]").getAttribute("value");
            $productName = $tr.querySelector("[name=productName]").getAttribute("value");
            $price = $tr.querySelector("[name=price]").getAttribute("value");
            $count = $tr.querySelector("[name=count]").getAttribute("value");
            $total = $tr.querySelector("[name=total]").getAttribute("value");
            $product = {
                'barcode': $barcode,
                'productName': $productName,
                'sellingPrice': $price,
                'count': $count,
                'itemTotalPrice': $total
            }
            $products.push($product);
        });
        return $products;
    }

    function itemExists(barcode) {
        state = false;
        $trs = tbody.querySelectorAll("tr");
        [...$trs].forEach(function($tr) {
            $barcode = $tr.querySelector("[name=barcode]").getAttribute("value");
            if (barcode == $barcode) {
                state = true;

            }
        });
        return state;
    }

    function updateItem(barcode, count, sellingPrice) {
        $tr = getTr(barcode);
        $tr.querySelector("[name=count]").innerText = parseInt($tr.querySelector("[name=count]").getAttribute("value")) + parseInt(count);
        $tr.querySelector("[name=count]").setAttribute("value", parseInt($tr.querySelector("[name=count]").getAttribute("value")) + parseInt(count));
        $tr.querySelector("[name=total]").setAttribute("value", parseInt($tr.querySelector("[name=count]").getAttribute("value")) * sellingPrice);
        $tr.querySelector("[name=total]").innerText = parseInt($tr.querySelector("[name=count]").getAttribute("value")) * sellingPrice;
    }

    function getCurrentCount(barcode, count) {
        if (itemExists(barcode)) {
            return itemCount(getTr(barcode)) + count;
        } else {
            return count;
        }
    }

    function getTr(barcode) {
        barcodee = barcode.toString();
        return tbody.querySelector(`tr td[value="${barcodee}"]`).parentElement;
    }

    function itemCount($tr) {
        return parseInt($tr.querySelector("[name=count]").getAttribute("value"));
    }

    function updateTotal() {
        $total = 0;
        $trs = tbody.querySelectorAll("tr");
        [...$trs].forEach(function($tr) {
            $total += parseInt($tr.querySelector("[name=total]").getAttribute("value"));
        });
        totalSpan.innerText = $total;
    }

    function updateItemCount() {
        $count = 0;
        $trs = tbody.querySelectorAll("tr");
        [...$trs].forEach(function($tr) {
            $count += itemCount($tr);
        });
        cc.innerText = $count;
    }

    function updateAll() {
        updateTotal();
        updateItemCount();
    }

    function removeFromTable(barcode) {
        barcodee = barcode.toString();
        tbody.removeChild(tbody.querySelector(`tr td[value="${barcodee}"]`).parentElement);
        updateAll();
        sendUpdateSessionRequest();
    }
</script>
@endsection