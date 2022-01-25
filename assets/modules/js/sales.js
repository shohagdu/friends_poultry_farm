$(function () {
    $("#productName").focus();
    $("#member_status").hide();
    $("#member_status_red").hide();
});
$("#productName").autocomplete({

    source: function (request, response) {
        $.getJSON(base_url+"pos/get_product_list_by_branch", {term: request.term},
            response);
    },
    response: function (event, ui) {
        if(ui.content){
            if(ui.content.length == 1){
                addRowProduct(ui.content[0].id, ui.content[0].current_stock_item, ui.content[0].productPrice, ui.content[0].value,ui.content[0].productCode,ui.content[0].unit_sale_price);
                $(this).val('');
                $(this).focus();
                $(this).autocomplete('close');
                return false;
            }
        }

    },
    select: function (event, ui) {
        addRowProduct(ui.item.id, ui.item.current_stock_item, ui.item.productPrice, ui.item.value,ui.item.productCode,ui.item.unit_sale_price);
        $(this).val('');
        return false;
    }

});

var addRowProduct = function (id, inventory, price, value,  productCode,unit_sale_price) {
            $("#emptyProduct").hide();
            if(isNaN(inventory) || inventory < 1 ){
                alert('Sorry!  Your Searching Product is out of Stock');
                return  false;
            }

            // todo: IF PRODUCT IS EXIST THEN AUTOMATIC ADD IN QUEUE START
                var productID = parseFloat($('#productID_' + id).val());
                var productQuantity = parseInt($('#qty_' + id).val());
                var productInventory = parseFloat($("#inventory_" + id).val());
                var productPrice = parseFloat($("#price_" + id).val());
                if (productID == id) {
                    if (productInventory >= productQuantity + 1) {
                        $('#qty_' + id).val(productQuantity + 1);
                        if (!isNaN(productPrice)) {
                            var total = (productQuantity + 1) * productPrice;
                            $('#sub_total_' + id).val(total.toFixed(2));
                        }
                        return findTotal();
                    } else {
                        return findTotal();

                    }
                }
             // todo: IF PRODUCT IS EXIST THEN AUTOMATIC ADD IN QUEUE END

            $('<tr>\n\
                        <td style="width:30%;" class="appenTd">' + value + ' <span class="badge pull-right"> Stock '+ inventory +'</span><div style="color:red;font-size:11px;text-align: center" class="badge" id="qty_empty_'+id+'"></div> </td>\n\
                <td style="text-align:center;width:10%;" class="appenTd"><input id="price_' + id + '" tabindex="-1" name="price[]" value="' + unit_sale_price + '" style="text-align: center;height:30px;" class="unit_price" type="text"></td>\n\
                    <td style="text-align:center;width:15%;" class="appenTd"><input id="qty_' + id + '" type="text"\
                     class="quantity form-control" name="qty[]" value="1" style="text-align: center;height:30px;"\
                      >\n\
                    <input id="productID_' + id + '" name="productID[]" value="' + id + '" type="hidden">\n\
                     <input id="inventory_' + id + '" name="invantory[]" value="' + inventory + '" type="hidden">\n\
                    </td>\n\
                    <td style="width:15%;text-align:center;"  class=" appenTd" style="width:20%" id="total_' + id + '"> <input id="sub_total_' + id + '" name="sub_total[]" class="totalprice" readonly style="text-align: center;height:30px;" value="' + (unit_sale_price * 1).toFixed(2) + '" tabindex="-1"   type="text"></td>\n\
                    <td class="appenTd" style="width:15%;text-align:center;padding-top:5px;padding-bottom:0px;"><button tabindex="-1" class="btn btn-danger btn-sm" id="removeRow"><i class="glyphicon glyphicon-trash" style="cursor:pointer;"></i>  </button></td>\n\
                    </tr>').appendTo('#tableDynamic');
            return findTotal();

        };
        $(document).on("click", "#removeRow", function (e) {
            var target = e.target;
            $(target).closest('tr').remove();
            findTotal();
        });
        function findTotal() {
            if ($("#tableDynamic tr").size() == 0) {
                return $("#totalAmount").val(0);
            }
            $("#tableDynamic tr").each(function () {
                row_total = 0;
                $(".totalprice").each(function () {
                    row_total += Number(parseFloat($(this).val()));
                });    
                if (!isNaN(row_total)) {
                    var discount = parseFloat($("#discount").val());
                    if(isNaN(discount)){
                        var discountAmt=0;
                    }else{
                        var discountAmt=discount;
                    }

                    var  discountPercent = parseFloat($("#discountPercent").val());
                    if(isNaN(discountPercent) && isNaN(discountAmt)){
                        var discountAmount=0;
                    }else if(isNaN(discountPercent) &&  !(isNaN(discountAmt)) ){
                       var  discountAmount=discountAmt;
                    }else if(!isNaN(discountPercent) &&  !(isNaN(discountAmt)) ){
                        var discountAmount=discountAmt;
                    }
                    $("#subTotal").val(row_total.toFixed(2));
                    $("#totalAmount").val((row_total  - discountAmount).toFixed(2));

                    //when entry payment amount 
                    var  paymentAmount = parseFloat($("#paidNow").val());
                    var  totalAmount = parseFloat($("#totalAmount").val());
                    var  customerPreviousDue = parseFloat($("#customerPreviousDue").val());


                    if(isNaN(paymentAmount)){
                        var paymentAmountVal=0;
                    }else{
                        var paymentAmountVal=paymentAmount;
                    }
                    if(isNaN(customerPreviousDue)){
                        var customerPreviousDueVal=0;
                    }else{
                        var customerPreviousDueVal=customerPreviousDue;
                    }


                    
                    if(!isNaN(paymentAmount)){
                        var currentDue=(totalAmount-paymentAmountVal);
                        var previouDue=(currentDue+customerPreviousDueVal)
                        $("#currentDueAmount").val((currentDue).toFixed(2));
                        $("#totalCustomerDue").val((previouDue).toFixed(2));
                    }else{
                        var currentDue=(totalAmount+customerPreviousDueVal);
                        $("#totalCustomerDue").val((currentDue).toFixed(2));
                    }


                }else if((row_total==0) || isNaN(row_total)){
                    $("#discount").val('0');
                    $("#discountPercent").val('0');
                    $("#subTotal").val('0.00');
                    $("#totalAmount").val('0.00');
                    $("#currentDueAmount").val('0.00');
                    $("#totalCustomerDue").val('0.00');
                }
            });
        };
        $("input, textarea, select").keypress(function (event) {
            if (event.which == '10' || event.which == '13') {
                event.preventDefault();
            }
        });
        $(document).on("keyup", ".quantity", function (event) {
            var quantity = parseFloat($(this).val());
            var id_arr = $(this).attr('id');
            var id = id_arr.split("_");
            var element_id = id[id.length - 1];
            var inventory = parseFloat($("#inventory_" + element_id).val());
            var price = parseFloat($("#price_" + element_id).val());
            if(!isNaN(inventory) && !isNaN(quantity) && ( quantity > inventory) ){
                var stockmessage='Expected Qty is out of stock';
                $("#qty_" + element_id).val('1');
                $("#sub_total_" + element_id).val((price * 1).toFixed(2));
                $("#qty_empty_" + element_id).html(stockmessage);
                return false;
            }else if(!isNaN(inventory) && !isNaN(quantity) && (  inventory >=quantity ) ){
                $("#sub_total_" + element_id).val((price * quantity).toFixed(2));
                $("#qty_empty_" + element_id).html('');
                findTotal();
            }
        });

        $(document).on("keyup", ".unit_price", function (event) {
            var  price = parseFloat($(this).val());
            var id_arr = $(this).attr('id');
            var id = id_arr.split("_");
            var element_id = id[id.length - 1];
           // var inventory = parseFloat($("#inventory_" + element_id).val());
            var quantity = parseFloat($("#qty_" + element_id).val());
            if (!isNaN(price)) {
                $("#sub_total_" + element_id).val((price * quantity).toFixed(2));
                findTotal();

            }
        });
        $(document).on("keyup", "#paidNow", function (event) {
            var  paymentAmount = parseFloat($(this).val());
            var  totalAmount = parseFloat($("#totalAmount").val());
            var  customerPreviousDue = parseFloat($("#customerPreviousDue").val());
            if(isNaN(paymentAmount)){
                var paymentAmountVal=0;
            }else{
                var paymentAmountVal=paymentAmount;
            }
            if(isNaN(customerPreviousDue)){
                var customerPreviousDueVal=0;
            }else{
                var customerPreviousDueVal=customerPreviousDue;
            }
            
            if(!isNaN(paymentAmount)){
                var currentDue=(totalAmount-paymentAmountVal);
                var previouDue=(currentDue+customerPreviousDueVal)
                $("#currentDueAmount").val((currentDue).toFixed(2));
                $("#totalCustomerDue").val((previouDue).toFixed(2));
            }
        });
        


        
        $('#discount').keyup(function () {
            findTotal();
        });

    
    

        $('input[name="discountType"]').on('change', function () {
            var val = $('input[name="discountType"]:checked').val();
            if (val == 1) {
                $('#percentP').show();
                $('#discount').attr('readonly', true);
            } else {
                $('#percentP').hide();
                $('#discount').attr('readonly', false);
            }
        });
    
        $(document).on("keyup", "#discountPercent", function (event) {
            var subTotal = parseFloat($("#subTotal").val());
            var total = subTotal;
            var discountPerchanage = parseFloat($(this).val());

           if (!isNaN(discountPerchanage)) {
               var discountPercent = parseFloat($(this).val());
               var discountAmount = discountPercent / 100 * total;
               var newDis = discountAmount.toFixed(2);
               $("#discount").val(newDis);
               findTotal();
            }else{
               $("#discount").val('0');
               $("#discountPercent").val('0');
               findTotal();
           }
        });

        setTimeout(function() {
            $("#emptyMember").hide('blind', {}, 500)
        }, 5000);
    
        $(function () {
            $("#emptyMember").hide()
            $("#showMemberInfo").hide();
            $('#datepicker').datepicker({
                autoclose: true,
                endDate: '+0d',
                format: 'yyyy-mm-dd'
            });
            $('.datepicker').datepicker({
                autoclose: true,
                endDate: '+0d',
                format: 'dd-mm-yyyy'
            });
    
        });

        $("#confirmModal").on("click", function (e) {
            $("#show_error_save_main").html('');
            var customerId = $("#cst_id").val();
            var allAreRunningCustomer = $('input[name="allAreRunningCustomer"]:checked').val();
            // console.log(allAreRunningCustomer);
            if (customerId == ''  &&  typeof allAreRunningCustomer=='undefined') {
                $("#emptyMember").show();
                $("#salesConfirmModal").modal("hide");
            } else {
                $("#emptyMember").hide('blind', {}, 500)
                $("#salesConfirmModal").modal("show");
    
                var name = $("#showName").html();
                var subAmount = $("#totalAmount").val();
                var paidNow = $("#paidNow").val();
                var currentDueAmount = $("#currentDueAmount").val();
                var customerPreviousDue = $("#customerPreviousDue").val();
                var totalCustomerDue = $("#totalCustomerDue").val();

                if(isNaN(paidNow) || paidNow=='' || paidNow=='0.00' ){
                    var paidNowAmount='0.00';
                }else{
                    var paidNowAmount=paidNow;
                }
                if(isNaN(currentDueAmount) || currentDueAmount=='' || currentDueAmount=='0.00' ){
                    var currentDueAmountT='0.00';
                }else{
                    var currentDueAmountT=currentDueAmount;
                }
                if(isNaN(customerPreviousDue) || customerPreviousDue=='' || customerPreviousDue=='0.00' ){
                    var customerPreviousDueT='0.00';
                }else{
                    var customerPreviousDueT=customerPreviousDue;
                }
                if(isNaN(totalCustomerDue) || totalCustomerDue=='' || totalCustomerDue=='0.00' ){
                    var totalCustomerDueT='0.00';
                }else{
                    var totalCustomerDueT=totalCustomerDue;
                }

                $("#showConfirmName").html(name);
                $("#showNetTotal").html(subAmount);
                $("#showPaymentAmount").html(paidNowAmount);
                $("#showCurrentDueAmount").html(currentDueAmountT);
                $("#showPreviousDueAmount").html(customerPreviousDueT);
                $("#showTotalDueAmount").html(totalCustomerDueT);

    
            }
        });
    
    
        $("#tags_11").autocomplete({
            source: base_url +'pos/getcustomername',
            select: function (event, ui) {
                $("#showMemberInfo").show();
                var name = ui.item.value;
                var hr = name.split("(");
                var codeSplit = hr[1].split(")");
                $("#tags_11").val(ui.item.value);
                $("#cst_id").val(ui.item.id);
                $("#mobile").html(ui.item.mobile);
                $("#member_mobile").val(ui.item.mobile);
                $("#showName").html(hr[0]);
                $("#showEmail").html(ui.item.email);
                $("#showAddress").html(ui.item.address);
                $("#customerPreviousDue").val(ui.item.current_due_data);

            }
        });

function addCustomerMemberInfoPos() {
    $("#customerMemberInfoForm")[0].reset();
    $("#alert_error").hide();
}
function saveCustomerMemberInfoPos() {
   $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"settings/save_customer_member_info/",
        data: $('#customerMemberInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#customerMemberInfoForm")[0].reset();
                $('#CustomerInfoModal').modal('hide');
                var data=response.data;
                $("#showMemberInfo").show();
                var name_show = data.name+' ('+data.mobile+') ' + data.address;
                $("#tags_11").val(name_show);
                $("#cst_id").val(data.id);
                $("#mobile").html(data.mobile);
                $("#member_mobile").val(data.mobile);
                $("#showName").html( data.name);
                $("#showEmail").html(data.email);
                $("#showAddress").html(data.address);
                $("#customerPreviousDue").val('0.00');

            }
        }
    });
}

function saveSalesInfo() {
      $("#payment_genarel").attr("disabled", true);
    $.ajax({
        url:  base_url +"pos/save_sales_info/",
        data: $('#salesForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $("#payment_genarel").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save_main").html(response.message);
            }else{
                $("#salesForm")[0].reset();
                $('#salesConfirmModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}

function isCheckedById(elem) {
    var id = $(elem).attr("id");
    if($('#'+ id + '').is(':checked')){
        $("#"+id+"_amount").attr('readonly',false);
    }else{
        $("#"+id+"_amount").attr('readonly',true);
    }
}


$('.payment_ctg_amount').keyup(function () {
    row_total_info = 0;
    $(".payment_ctg_amount").each(function () {
        var val=parseFloat($(this).val());
        if(isNaN(val)){
            value_a=0;
        }else{
            value_a=val;
        }
        row_total_info += Number(value_a);
    });
    $("#paidNow").val(row_total_info);
    findTotal();
});
