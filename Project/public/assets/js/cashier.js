const cashForm = document.querySelector(".cashierForm");
cashForm.addEventListener('submit', function(e) {
    e.preventDefault();
    let barcode = $("input[name=barcode]").val();
    let count = $("input[name=count]").val();
    let currentPrice = $("input[name=price]").val();
    let _token = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "/ajax-request", // send request to product 
        type: "POST",
        data: {
            barcode: barcode,
            count: count,
            _token: _token
        },
        success: function(response) {
            if (response) {
                // get the json file and convert it to array 
                // add that product and count to the table 
                // update the total price 
            }
        },
        error: function(error) {
            // handle errors here
        }
    });
});