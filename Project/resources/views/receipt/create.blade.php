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
            <h3 class="page-title"> Receipt </h3>
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
                                        <th>Barcode</th>
                                        <th>Product Name</th>
                                        <th>Selling Price</th>
                                        <th>Purcashing Price</th>
                                        <th>Count</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(Session::has('receiptItems'))
                                    @foreach(Session::get('receiptItems') as $product)
                                    <tr>
                                        <td name="barcode" value="{{$product['barcode']}}">{{$product['barcode']}}</td>
                                        <td name='productName' value="{{$product['productName']}}">{{$product['productName']}}</td>
                                        <td name="sellingPrice" value="{{$product['sellingPrice']}}">{{$product['sellingPrice']}}</td>
                                        <td name="purcashingPrice" value="{{$product['purcashingPrice']}}">{{$product['purcashingPrice']}}</td>
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
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-lg-2 grid-margin stretch-card" style="margin-top: 20px;">
                                <div class="card">
                                    <label class="form-label">Company</label>
                                    <select style="color: white" name="companyID" class="form-control">
                                        <option value="" disabled selected>Select Company</option>
                                        @forelse ($companies as $company)
                                        <option value="{{$company->companyID}}">{{$company->companyName }}</option>
                                        @empty
                                        <option value="" disabled selected>No Companies</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 grid-margin stretch-card" style="margin-top: 20px;">
                                <div class="card">
                                    <button class="btn btn-primary me-2" style="padding: 10px;" id="cash">Add</button>
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
        total = document.querySelector("#totalSpan").innerText;
        counter = document.querySelector("#itemCount").innerText;
        companyID = document.querySelector("[name='companyID']").options[document.querySelector("[name='companyID']").selectedIndex].value;
        data = convertTrToArray();
        $.ajax({
            url: "/receipt",
            type: "POST",
            data: {
                data: data,
                totalPrice: total,
                itemCount: counter,
                companyID: companyID,
                _token: $('meta[name="csrf-token"]').attr('content')
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
                            type: 5,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log("success");
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
                console.log(error);
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
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "/ajaxRequest", // send request to product 
            type: "POST",
            data: {
                barcode: barcode,
                count: count,
                type: 3,
                _token: _token
            },
            success: function(response) {
                if (response['status'] == 200) {
                    const product = JSON.parse(response['product']);
                    if (!itemExists(product['barcode'], count, product['purcashingPrice'])) {
                        addItem(product, barcode, count);
                    } else {
                        updateItem(barcode, initialCount, product['purcashingPrice']);
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
                console.log(error);
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
                type: 4,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // console.log(response);
            },
            error: function(error) {
                // console.log(error);
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
        const sellingPrice = document.createElement("td");
        const purcashingPrice = document.createElement("td");
        const countTD = document.createElement("td");
        const totalTD = document.createElement("td");
        const removeTD = document.createElement("td");
        barcodeTD.setAttribute("name", 'barcode');
        barcodeTD.setAttribute("value", barcode);
        productNameTD.setAttribute("name", "productName");
        productNameTD.setAttribute("value", product['productName']);
        sellingPrice.setAttribute("name", "sellingPrice");
        purcashingPrice.setAttribute("name", "purcashingPrice");
        sellingPrice.setAttribute("value", product['sellingPrice']);
        purcashingPrice.setAttribute("value", product['purcashingPrice']);
        countTD.setAttribute("name", "count");
        countTD.setAttribute("value", count);
        totalTD.setAttribute("name", "total");
        totalTD.setAttribute("value", product['purcashingPrice'] * count);
        barcodeTD.innerText = product['barcode'];
        productNameTD.innerText = product['productName'];
        sellingPrice.innerText = product['sellingPrice'];
        purcashingPrice.innerText = product['purcashingPrice'];
        countTD.innerText = count;
        totalTD.innerText = product['purcashingPrice'] * count;
        removeTD.innerText = "Remove";
        removeTD.setAttribute("value", product['barcode']);
        removeTD.classList.add("removeButton");
        removeTD.addEventListener('click', function(e) {
            removeFromTable(this.getAttribute("value"));
        });
        tr.appendChild(barcodeTD);
        tr.appendChild(productNameTD);
        tr.appendChild(sellingPrice);
        tr.appendChild(purcashingPrice);
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
            $sellingPrice = $tr.querySelector("[name=sellingPrice]").getAttribute("value");
            $purcashingPrice = $tr.querySelector("[name=purcashingPrice]").getAttribute("value");
            $count = $tr.querySelector("[name=count]").getAttribute("value");
            $total = $tr.querySelector("[name=total]").getAttribute("value");
            $product = {
                'barcode': $barcode,
                'productName': $productName,
                'sellingPrice': $sellingPrice,
                'purcashingPrice': $purcashingPrice,
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

    function updateItem(barcode, count, purcashingPrice) {
        $tr = getTr(barcode);
        $tr.querySelector("[name=count]").innerText = parseInt($tr.querySelector("[name=count]").getAttribute("value")) + parseInt(count);
        $tr.querySelector("[name=count]").setAttribute("value", parseInt($tr.querySelector("[name=count]").getAttribute("value")) + parseInt(count));
        $tr.querySelector("[name=total]").setAttribute("value", parseInt($tr.querySelector("[name=count]").getAttribute("value")) * purcashingPrice);
        $tr.querySelector("[name=total]").innerText = parseFloat($tr.querySelector("[name=count]").getAttribute("value")) * purcashingPrice;
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
            $total += parseFloat($tr.querySelector("[name=total]").getAttribute("value"));
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