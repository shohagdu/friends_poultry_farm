$(function () {
    $("#example1").DataTable();
    $('#tbl1').DataTable({
        orderable: false,
        "ordering": false
    });
    //Initialize Select2 Elements
    $(".select2").select2();
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
    //Date picker
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

    $('#datepicker_no_one').datepicker({
        format: 'yyyy-mm-dd',
        autoclose:true
    });
    $('#datepicker_no_two').datepicker({
        format: 'yyyy-mm-dd',
        autoclose:true
    });

    $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    //Date range picker
    $('#reservation').daterangepicker({
        locale: {
            format: 'YYYY/MM/DD'
        }
    });

});
function get_element_id(id_arr){
    var id = id_arr.split("_");
    return  id[id.length - 1];
}
function goBack() {
    window.history.back();
}
$(function () {
    $(".only-number").keydown(function (event) {
        if (event.shiftKey == true) {
            event.preventDefault();
        }

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

        } else {
            event.preventDefault();
        }

        if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
            event.preventDefault();

    });
});

//            month picker
$(document).ready(function () {
    $(".monthPicker").datepicker({
        dateFormat: 'mm/yy',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,

        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).val($.datepicker.formatDate('mm/yy', new Date(year, month, 1)));
        }
    });

    $(".monthPicker").focus(function () {
        $(".ui-datepicker-calendar").hide();
        $("#ui-datepicker-div").position({
            my: "center top",
            at: "center bottom",
            of: $(this)
        });
    });

});

// Settings information
function addSettingInfo() {
    $("#setting_info_form")[0].reset();
    $("#upId").val('');
    $("#updateBtn").hide();
    $("#saveBtn").show();
}
function updateSettingInfo(id) {
    $("#setting_info_form")[0].reset();
    $("#upId").val('');
    $("#updateBtn").show();
    $("#saveBtn").hide();
    $.ajax({
        url: base_url + "settings/get_single_settings_info/",
        data: {id:id},
        type: "POST",
        dataType: 'JSON',
        success: function (response) {
            if (response.status == 'success') {
                var data=response.data;
                $("#title").val(data.title);
                $("#status").val(data.is_active);
                $("#upId").val(data.id);
            }
        }
    });
}

function saveSettingInfo() {
    $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"settings/save_settings_info/",
        data: $('#setting_info_form').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}



$(document).ready(function(){
        $('#settingsInfo').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':   base_url +"settings/showAllSettingsInfo",
                'data': function(data){
                    data.type = $('#type_info').val();
                }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'title', name: 'all_settings_info.title' },
            { data: 'is_active', name: 'is_active' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

});



function updateProductInfo(productid) {
    $("#productInfoForm")[0].reset();
    $("#show_label").html('Update');
    $(".addInventoryCheckDiv").hide();
    $(".showAddInventory").hide();
    $.ajax({
        url: base_url +"products/get_single_product_info",
        data: {id: productid},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                var data=response.data;
                $("#productCode").val(data.productCode);
                $("#productNameShow").val(data.name);
                $("#productBrand").val(data.band_id);
                $("#productSource").val(data.source_id);
                $("#productType").val(data.product_type);
                $("#productUnit").val(data.unit_id);
                $("#productPrice").val(data.unit_sale_price);
                $("#productPurchasePrice").val(data.purchase_price);
                $("#status").val(data.is_active);
                $("#upId").val(data.id);
            }
        }
    });
}

function addProductInfo() {
    $("#productInfoForm")[0].reset();
    $("#upId").val('');
    $("#show_label").html('Save');
    $("#purchaseNo").val('SIN-'+randomString(10));
    $('.showAddInventory').hide();
    $(".addInventoryCheckDiv").show();
}
$(".addItemInventory").click(function() {
    $('.clearInput').val('');
    if($(this).is(":checked")) {
        $(".showAddInventory").show(300);
    } else {
        $(".showAddInventory").hide(200);
    }
});

function saveProductInfo() {
    $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"products/save_product_info/",
        data: $('#productInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#productInfoForm")[0].reset();
                $('#productModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}
// customer information
var LoadFile=function(event){
    var output=document.getElementById("img_id");
    document.getElementById("img_div").style.display = "block";
    output.src=URL.createObjectURL(event.target.files[0]);
}
function addCustomerMemberInfo() {
    $("#customerMemberInfoForm")[0].reset();
    $("#show_label").html('Save');
    $("#alert_error").hide();
}
function updateCustomerMemberInfo(id) {
    $("#customerMemberInfoForm")[0].reset();
    $("#show_label").html('Update');
    $("#alert_error").hide();
    $.ajax({
        url: base_url +"settings/get_single_customer_member_info",
        data: {id: id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                var data=response.data;
                $("#outlet_id").val(data.outlet_id);
                $("#name").val(data.name);
                $("#mobile").val(data.mobile);
                $("#email").val(data.email);
                $("#address").val(data.address);
                $("#remarks").val(data.remarks);
                $("#status").val(data.is_active);
                $("#upId").val(data.id);
            }
        }
    });


}
function deleteCustomerMemberInfo(id,type) {
    var confirmation = confirm("Are you sure you want to remove this Member?");

    if (confirmation) {
        $.ajax({
            url: base_url + "settings/deleteMemberInfo",
            data: {id: id, type: type},
            type: "POST",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                        $('#MemberInfo').DataTable().ajax.reload();
                    }, 1500);
                } else {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                    }, 3500);
                }
            }
        });
    }


}
function saveCustomerMemberInfo() {
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
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}
$(document).ready(function(){
    var ProductInfoTable = $('#ProductInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"products/showAllProductInfo",
            'data': function(data){
                data.bandID = $('#bandID').val();
                data.sourceID = $('#sourceID').val();
                data.typeID = $('#typeID').val();
                data.productName = $('#productName').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'name', name: 'product_info.name' },
            { data: 'productCode', name: 'product_info.productCode' },
            { data: 'bandTitle', name: 'band.bandTitle' },
            { data: 'sourceTitle', name: 'source.sourceTitle'},
            { data: 'ProductTypeTitle', name: 'productType.ProductTypeTitle'},
            { data: 'unitTitle',  name: 'unitInfo.unitTitle'},
            { data: 'unit_sale_price', name: 'product_info.unit_sale_price' },
            { data: 'is_active', name: 'product_info.is_active' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#bandID,#sourceID,#typeID').change(function(){
        ProductInfoTable.draw();
    });
    $('#productName').keyup(function(){
        ProductInfoTable.draw();
    });

    //customer information......
    var customerMemberInfoTable = $('#customerMemberInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"settings/showAllCustomerInfo",
            'data': function(data){
                data.outletID = $('#outletID').val();
                data.typeID = $('#typeInfo').val();
                data.customerName = $('#customerName').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'name', name: 'customer_shipment_member_info.name' },
            { data: 'outlet_name', name: 'outlet_setup.outlet_name' },
            { data: 'mobile', name: 'customer_shipment_member_info.mobile' },
            { data: 'email', name: 'customer_shipment_member_info.email'},
            { data: 'address', name: 'customer_shipment_member_info.address'},
            { data: 'remarks', name: 'customer_shipment_member_info.remarks'},
            { data: 'current_due', name: 't.current_due' },
            { data: 'is_active', name: 'customer_shipment_member_info.is_active' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#outletID').change(function(){
        customerMemberInfoTable.draw();
    });
    $('#customerName').keyup(function(){
        customerMemberInfoTable.draw();
    });

    // Member
    var MemberInfoTable = $('#MemberInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"shipment_info/showAllMemmberInfo",
            'data': function(data){
                data.typeID = 2;
                data.customerName = $('#customerName').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'name', name: 'customer_shipment_member_info.name' },
            { data: 'mobile', name: 'customer_shipment_member_info.mobile' },
            { data: 'email', name: 'customer_shipment_member_info.email'},
            { data: 'address', name: 'customer_shipment_member_info.address'},
            { data: 'remarks', name: 'customer_shipment_member_info.remarks'},
            { data: 'current_stock', name: 't.current_stock' },
            { data: 'current_due', name: 't.current_due' },
            { data: 'is_active', name: 'customer_shipment_member_info.is_active' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#customerName').keyup(function(){
        MemberInfoTable.draw();
    });

    

    //outlet information....
    var outletInfoTable = $('#outletInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"settings/showAllOutletInfo",
            'data': function(data){
                data.outletName = $('#outletName').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'name', name: 'outlet_setup.name' },
            { data: 'mobile', name: 'customer_shipment_member_info.mobile' },
            { data: 'email', name: 'customer_shipment_member_info.email'},
            { data: 'address', name: 'customer_shipment_member_info.address'},
            { data: 'parent_outlet_name', orderable: true, searchable: false},
            { data: 'is_active', name: 'customer_shipment_member_info.is_active' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#outletName').keyup(function(){
        outletInfoTable.draw();
    });

    //purchase information......
    var purchaseInfoTable = $('#purchaseInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"purchases/showAllPurchaseInfo",
            'data': function(data){
                data.purchaseID = $('#purchaseNoSearch').val();
                data.productCode = $('#productCode').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'purchase_id', name: 'purchase_info_stock_in.purchase_id' },
            { data: 'purchase_date', name: 'purchase_info_stock_in.purchase_date' },
            { data: 'productInfo', name: 'product_info.productCode' },
            { data: 'note', name: 'purchase_info_stock_in.note'},
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#purchaseNoSearch,#productCode').keyup(function(){
        purchaseInfoTable.draw();
    });

    // todo:: sales list information

    var SalesInfoTable = $('#SalesInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"pos/showAllSalesInfo",
            'data': function(data){
                data.customerID = $('#customerID_11').val();
                data.saleNo = $('#salesID').val();
                data.dateRange = $('#reservation').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'invoice_no', name: 'sales_info.invoice_no' },
            { data: 'customer_info', name: 'sales_info.customer_info' },
            { data: 'sales_date', name: 'sales_info.sales_date' },
            { data: 'net_total', name: 'sales_info.net_total'},
            { data: 'action',orderable: false, searchable: false },
        ]
    });
    $('#customerName_11,#salesID,#reservation').change(function(){
        SalesInfoTable.draw();
    });

    //Transfer information......
    var transferInfoTable = $('#transferInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"transfer/showAllTransferInfo",
            'data': function(data){
                data.fromOutletID = $('#fromOutletID').val();
                data.toOutletID = $('#toOutletID').val();
                data.transferNo = $('#transferNo').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'transfer_id', name: ' transfer_info.transfer_id' },
            { data: 'transfer_date', name: 'transfer_info.transfer_date'},
            { data: 'from_outlet_name', name: 'outlet_setup.from_outlet_name' },
            { data: 'to_outlet_name', name: 'outlet_setup.to_outlet_name' },

            { data: 'note', name: 'transfer_info.note'},
            { data: 'is_active', name: 'transfer_info.is_active' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#fromOutletID,#toOutletID').change(function(){
        transferInfoTable.draw();
    });
    $('#transferNo').keyup(function(){
        transferInfoTable.draw();
    });

    //todo:: Shipment moduelse start
    // Shipment setup
    //customer information......
    $('#shipmentSetupTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
                'url':  base_url +"shipment_info/showAllShipmentSetup",
                'data': function(data){
                }
            },
            'columns': [
                { data: 'serial_no', orderable: true, searchable: false  },
                { data: 'title', name: 'shipment_record.title' },
                { data: 'arrival_dt', name: 'shipment_record.arrival_dt' },
                { data: 'receive_dt', name: 'shipment_record.receive_dt' },
                { data: 'details', name: 'shipment_record.details'},
                { data: 'is_active', name: 'shipment_record.is_active'},
                { data: 'action',orderable: false, searchable: false },
            ]
        });

    //shipment stock In information......
    var shipmnetStockInfoTable = $('#shipmnetStockInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"shipment_info/showAllStockInfo",
            'data': function(data){
                data.shipmentID = $('#shipmentID').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'shipmentName', name: 'shipment_record.shipmentName' },
            { data: 'destibute_dt', name: 'shipment_stock_info.destibute_dt' },
            { data: 'shipment_net_total', name: 'purchase_info_stock_in.shipment_net_total' },
            { data: 'total_qty', name: 'purchase_info_stock_in.total_qty' },
            { data: 'note', name: 'purchase_info_stock_in.note'},
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#shipmentID').change(function(){
        shipmnetStockInfoTable.draw();
    });

    // delivery Record
    var shipmnetDeliveryInfoTable = $('#shipmnetDeliveryInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"shipment_info/showAllDeliveryInfo",
            'data': function(data){
                data.member = $('#memberid_1').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'member_name', name: 'member.member_name' },
            { data: 'trans_date', name: 'shipment_stock_details.trans_date' },
            { data: 'credit_qty', name: 'shipment_stock_details.credit_qty' },
            { data: 'remarks', name: 'shipment_stock_details.remarks' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#member_name_1').change(function(){
        shipmnetDeliveryInfoTable.draw();
    });

     // Shipment Delivery collection Record
    var shipmnetMemberDueCollectionInfoTable = $('#shipmnetMemberDueCollectionInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"shipment_info/showAllDueCollectionRecordInfo",
            'data': function(data){
                data.member = $('#memberid_1').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'member_name', name: 'member.member_name' },
            { data: 'trans_date', name: 'shipment_stock_details.trans_date' },
            { data: 'credit_amount', name: 'shipment_stock_details.credit_amount' },
            { data: 'remarks', name: 'shipment_stock_details.remarks' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#member_name_1').blur(function(){
        shipmnetMemberDueCollectionInfoTable.draw();
    });

    // Customer Due collection Record
    var customerDueCollectionInfoTable = $('#customerDueCollectionInfo').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        //'searching': false, // Remove default Search Control
        'ajax': {
            'url':  base_url +"settings/showAllCustomerDueCollectionInfo",
            'data': function(data){
                data.customerID = $('#customerName_1').val();
            }
        },
        'columns': [
            { data: 'serial_no', orderable: true, searchable: false  },
            { data: 'customer_info', name: 'member.customer_info' },
            { data: 'payment_date', name: 'transaction_info.payment_date' },
            { data: 'credit_amount', name: 'transaction_info.credit_amount' },
            { data: 'remarks', name: 'transaction_info.remarks' },
            { data: 'action',orderable: false, searchable: false },
        ]
    });

    $('#customerName_1').blur(function(){
        customerDueCollectionInfoTable.draw();
    });




});
// outlet information.........
function addOutletInfo() {
    $("#outletInfoForm")[0].reset();
    $("#show_label").html('Save');
    $("#alert_error").hide();
}
function updateOutletInfo(id) {
    $("#outletInfoForm")[0].reset();
    $("#show_label").html('Update');
    $("#alert_error").hide();
    $.ajax({
        url: base_url +"settings/get_single_outlet_info",
        data: {id: id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                var data=response.data;
                $("#parent_outlet_id").val(data.parent_id);
                $("#name").val(data.name);
                $("#mobile").val(data.mobile);
                $("#email").val(data.email);
                $("#address").val(data.address);
                $("#status").val(data.is_active);
                $("#upId").val(data.id);
            }
        }
    });
}
function saveOutletInfo() {
      $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"settings/save_outlet_info/",
        data: $('#outletInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#outletInfoForm")[0].reset();
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}




// for purchase product
     $(".productName").autocomplete({
        source: base_url+ "purchases/productNameSuggestions",
        select: function (event, ui) {
            $("#productName_1").val(ui.item.value);
            $("#productID_1").val(ui.item.id);
            return false;
        }
    });

    var randomString = function(length) {
        var text = "";
        var possible = "123456789ABCDEFLMRWVXYZbcdefghkmnqrstvxyz";
        for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    // Document Ready Function
    $(function() {
        $("#purchaseNo").val('SIN-'+randomString(6));
        $("#tranferNo").val('TNO-'+randomString(6));
    });
    
    var scntDiv = $('#tableDynamic');
    var iStockIN = $('#tableDynamic tr').size() + 1;
    $('#addRowStockIn').on('click', function () {
        $(`<tr>
        <td>${iStockIN}</td>
        <td>
            <input type="text" id="productName_${iStockIN}" required data-type="productName" placeholder="Product Name" class="productName form-control">
            <input type="hidden" name="productID[]" id="productID_${iStockIN}" class="form-control">
        </td>
        <td><input type="text" required name="quantity[]" id="quantity_${iStockIN}" placeholder="Quantity" class="quantPurchase form-control only-number"></td>
         <td><input type="text" required name="unitPrice[]" id="unitPrice_${iStockIN}" placeholder="Unit Price" class="unitPrice form-control only-number"></td>
         <td><input type="text" required name="totalPrice[]" id="totalPrice_${iStockIN}" placeholder="Total Price" class="totalPrice form-control only-number"></td>
        <td><a href="javascript:void(0);" id="deleteRow_${iStockIN}"  class="deleteRow btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
    </tr>`).appendTo(scntDiv);

        // Product Name
        $(".productName").autocomplete({
            source: base_url+ "purchases/productNameSuggestions",
            select: function (event, ui) {
                var id_arr = $(this).attr('id');
                var id = id_arr.split("_");
                var element_id = id[id.length - 1];
                $("#productName_" + element_id).val(ui.item.value);
                $("#productID_" + element_id).val(ui.item.id);
                return false;
            }
        });
        iStockIN++;
        return false;
    });
         

    $(document).on("click", ".deleteRow", function (e) {
        if ($('#tableDynamic tr').size() > 1) {
            var target = e.target;

            var id_arr = $(this).attr('id');
            var id = id_arr.split("_");
            var element_id = id[id.length - 1];
            $(target).closest('tr').remove();


        } else {
            //alert('One row should be present in table');
        }
    });
    
    function savePurchaseInfo() {
         $(".submit_btn").attr("disabled", true);
        $.ajax({
            url:  base_url +"purchases/save_purchase_info/",
            data: $('#purchaseInfoForm').serialize(),
            type: "POST",
            dataType:'JSON',
            success: function (response) {
                $(".submit_btn").attr("disabled", false);
                if(response.status=='error'){
                    $("#alert_error").show();
                    $("#show_error_save").html(response.message);
                }else{
                    $("#purchaseInfoForm")[0].reset();
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function(){
                        window.location = base_url +response.redirect_page;
                    },1500);
    
                }
            }
        });
    }

    function saveOpeningStockInfo () {
        $(".submit_btn").attr("disabled", true);
        $.ajax({
            url:  base_url +"settings/save_opening_stock_info/",
            data: $('#outletOpeningStockForm').serialize(),
            type: "POST",
            dataType:'JSON',
            success: function (response) {
                $(".submit_btn").attr("disabled", false);
                if(response.status=='error'){
                    $("#alert_error").show();
                    $("#show_error_save").html(response.message);
                }else{
                    $("#outletOpeningStockForm")[0].reset();
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function(){
                        window.location = base_url +response.redirect_page;
                    },1500);

                }
            }
        });
    }
    function searchingInvantoryReport () {
        //$(".submit_btn").attr("disabled", true);
        $.ajax({
            url:  base_url +"reports/searcning_inventory_report/",
            data: $('#inventoryReportForm').serialize(),
            type: "POST",
            success: function (response) {
                $(".submit_btn").attr("disabled", false);
                if(response!=''){
                    $("#stock_info_data").html(response);
                }
            }
        });
    }
//------------------------------------------------------------------------------------------------------
// ----------------------------------Transfer Modules start---------------------------------------------
//------------------------------------------------------------------------------------------------------

function saveTransferInfo() {
   // $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"transfer/save_info/",
        data: $('#transferInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#transferInfoForm")[0].reset();
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}
//------------------------------------------------------------------------------------------------------
// ----------------------------------Shipment Modules start---------------------------------------------
//------------------------------------------------------------------------------------------------------

function addShipmentSetup() {
    $("#shipmentSetupInfoForm")[0].reset();
    $("#show_label").html('Save');
    $("#alert_error").hide();
}


function updatShipmentSetupInfo(id) {
    $("#shipmentSetupInfoForm")[0].reset();
    $("#show_label").html('Update');
    $("#alert_error").hide();
    $.ajax({
        url: base_url +"shipment_info/get_shipment_setup_info",
        data: {id: id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                var data=response.data;
                $("#title").val(data.title);
                $("#arrival_date").val(data.arrival_dt);
                $("#receive_date").val(data.receive_dt);
                $("#remarks").val(data.details);
                $("#status").val(data.is_active);
                $("#upId").val(data.id);
            }
        }
    });
}
function saveShipmentSetupInfo() {
    //$(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"shipment_info/save_shipment_setup/",
        data: $('#shipmentSetupInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
           // $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#shipmentSetupInfoForm")[0].reset();
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}

var scntDivShipment = $('#tableDynamicShipment');
var iStockINShipment = $('#tableDynamicShipment tr').size() + 1;
$('#addRowStockInShipment').on('click', function () {
    $(`<tr>
        <td>${iStockINShipment}</td>
        <td>
            <input type="text" id="member_name_${iStockINShipment}" required data-type="memberName" placeholder="Member Name" class="memberName form-control">
            <input type="hidden" name="memberID[]" id="memberid_${iStockINShipment}" class="form-control">
        </td>
        <td><input type="text" required name="quantity[]" value="1" id="quantity_${iStockINShipment}" placeholder="Quantity" class="quant form-control only-number"></td>
        <td><input type="text" required name="unit_price[]" id="unit_price_${iStockINShipment}"  placeholder="Unit Price" class="unit_price form-control only-number"></td>
        <td><input type="text" required name="sub_price[]" readonly id="sub_price_${iStockINShipment}"
                                               placeholder="0.00" class="form-control only-number"></td>
        <td><input type="text" required name="discount_price[]" id="discount_price_${iStockINShipment}"   placeholder="0.00" class="discount_price form-control only-number"></td>
        <td><input type="text" required name="net_total[]" readonly id="net_total_${iStockINShipment}"
                   placeholder="0.00" class="net_total form-control only-number"></td>
        
        <td><a href="javascript:void(0);" id="deleteRow_${iStockINShipment}"  class="deleteRow btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
    </tr>`).appendTo(scntDivShipment);

    // Product Name
    $(".memberName").autocomplete({
        source: base_url+ "shipment_info/memberNameSuggestion",
        select: function (event, ui) {
            var id_arr = $(this).attr('id');
            var id = id_arr.split("_");
            var element_id = id[id.length - 1];
            $("#member_name_" + element_id).val(ui.item.value);
            $("#memberid_" + element_id).val(ui.item.id);
            return false;
        }
    });
    iStockINShipment++;
    return false;
});

$(".memberName").autocomplete({
    source: base_url+ "shipment_info/memberNameSuggestion",
    select: function (event, ui) {
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        $("#member_name_" + element_id).val(ui.item.value);
        $("#memberid_" + element_id).val(ui.item.id);
        return false;
    }
});
$(".customerName").autocomplete({
    source: base_url+ "shipment_info/customerNameSuggestion",
    select: function (event, ui) {
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        $("#customerName_" + element_id).val(ui.item.value);
        $("#customerID_" + element_id).val(ui.item.id);
        return false;
    }
});
//shipment member application
function shipmentTotalCal() {
    if ($("#tableDynamicShipment tr").size() == 0) {
        return $("#total_amount").val(0);
    }
    $("#tableDynamicShipment tr").each(function () {
        row_total = 0;
        $(".net_total").each(function () {
            row_total += Number(parseFloat($(this).val()));
        });
        if (!isNaN(row_total)) {
            $("#total_amount").val(row_total.toFixed(2));
        }
    });
}
$(document).on("keyup", ".unit_price", function (event) {
    var  price = parseFloat($(this).val());
    var element_id = get_element_id($(this).attr('id'));
    var quantity = parseFloat($("#quantity_" + element_id).val());
    if (!isNaN(price)) {
        var sub_total=(price * quantity);
        $("#sub_price_" + element_id).val((sub_total).toFixed(2));
         var discount = parseFloat($("#discount_price_"+element_id).val());
        if(isNaN(discount)){
            var discountAmt=0;
        }else{
            var discountAmt=discount;
        }
        $("#net_total_"+element_id).val((sub_total  - discountAmt).toFixed(2));
        shipmentTotalCal();
    }else{
        $("#sub_price_" + element_id).val('0.00');
        $("#net_total_"+element_id).val('0.00');
        shipmentTotalCal();
    }
});

$(document).on("keyup", ".quant ", function (event) {
    var  quantity = parseFloat($(this).val());
    var element_id = get_element_id($(this).attr('id'));
    var price = parseFloat($("#unit_price_" + element_id).val());
    if(isNaN(price)){ var priceAmt=0;   }else{  var priceAmt=price; }
    if(isNaN(quantity)){var quantityAmt=0; }else{ var quantityAmt=quantity;}

    if (!isNaN(priceAmt) && !isNaN(quantityAmt)) {
        var sub_total=(priceAmt * quantityAmt);
        $("#sub_price_" + element_id).val((sub_total).toFixed(2));
         var discount = parseFloat($("#discount_price_"+element_id).val());

        if(isNaN(discount)){  var discountAmt=0;  }else{ var discountAmt=discount;  }

        $("#net_total_"+element_id).val((sub_total  - discountAmt).toFixed(2));
        shipmentTotalCal();
    }else{
        $("#sub_price_" + element_id).val('0.00');
        $("#net_total_"+element_id).val('0.00');
        shipmentTotalCal();
    }
});

$(document).on("keyup", ".discount_price ", function (event) {
    var  discount = parseFloat($(this).val());
    var element_id = get_element_id($(this).attr('id'));
    var price = parseFloat($("#unit_price_" + element_id).val());
    var quantity = parseFloat($("#quantity_" + element_id).val());

    if(isNaN(discount)){ var discountAmt=0;  }else{  var discountAmt=discount;}
    if(isNaN(price)){ var priceAmt=0;   }else{  var priceAmt=price; }
    if(isNaN(quantity)){var quantityAmt=0; }else{ var quantityAmt=quantity;}

    if (!isNaN(discountAmt) && !isNaN(priceAmt) && !isNaN(quantityAmt)) {
        var sub_total=(priceAmt * quantityAmt);
        $("#sub_price_" + element_id).val((sub_total).toFixed(2));
        $("#net_total_"+element_id).val((sub_total  - discountAmt).toFixed(2));
        shipmentTotalCal();
    }else{
        $("#sub_price_" + element_id).val('0.00');
        $("#net_total_"+element_id).val('0.00');
        shipmentTotalCal();
    }
});

function saveShipmentStockInfo() {
   // $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"shipment_info/save_shipment_stock_in_info/",
        data: $('#stockInInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#stockInInfoForm")[0].reset();
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}


// shipment Delivery

function addShipmentDelivery() {
    $("#shipmentDeliveryInfoForm")[0].reset();
    $("#show_label").html('Save');
    $("#alert_error").hide();
}
function saveShipmentDeliveryInfo() {
    $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"shipment_info/save_shipment_delivery/",
        data: $('#shipmentDeliveryInfoForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
             $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#shipmentDeliveryInfoForm")[0].reset();
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}

function updatShipmentDeliveryInfo(id) {
    $("#shipmentDeliveryInfoForm")[0].reset();
    $("#show_label").html('Update');
    $("#alert_error").hide();
    $.ajax({
        url: base_url +"shipment_info/get_single_shipment_delivery_info",
        data: {id: id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                var data=response.data;
                var currentStock=parseInt(data.present_stock_info)-parseInt(data.credit_qty);
                $("#member_name_11").val(data.member_name+' ['+data.mobile+' ]');
                $("#memberid_11").val(data.member_id);
                $("#due_qty").val(data.present_stock_info);
                $("#delivery_qty").val(data.credit_qty);
                $("#current_stock_qty").val(currentStock);
                $("#delivery_date").val(data.trans_date);
                $("#remarks").val(data.remarks);
                $("#status").val(data.is_active);
                $("#upId").val(data.id);
            }
        }
    });

}





// Member Due Collection
function addMemberDueCollection() {
    $("#MemberDueCollectionForm")[0].reset();
    $("#show_label").html('Save');
    $("#alert_error").hide();
}


function saveMemberDueCollection() {
    $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"shipment_info/save_member_due_collection/",
        data: $('#MemberDueCollectionForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
             $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#MemberDueCollectionForm")[0].reset();
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}

function updatShipmentMemberDueCollection (id) {
    $("#MemberDueCollectionForm")[0].reset();
    $("#show_label").html('Update');
    $("#alert_error").hide();
    $.ajax({
        url: base_url +"shipment_info/get_single_shipment_delivery_info",
        data: {id: id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                var data=response.data;
                /*
                    $("#cash").attr('checked',false);
                    $("#cash_cheque").attr('checked',false);
                    $("#due_cheque").attr('checked',false);
                    $("#online").attr('checked',false);
                */

                var paymentBy= JSON.parse(data.payment_by);
                $.each(paymentBy, function (key, value) {
                        $("#" + key).attr('checked', true);
                        $("#" + key + "_amount").attr('readonly', false);
                        $("#" + key + "_amount").val(value);

                });



                var current_due_ant=(parseFloat(data.present_due_amt)-parseFloat(data.credit_amount));
                var currentStock=parseInt(data.present_stock_info)-parseInt(data.credit_qty);
                $("#member_name_11").val(data.member_name+' ['+data.mobile+' ]');
                $("#memberid_11").val(data.member_id);
                $("#due_amount").val((data.present_due_amt).toFixed(2));
                $("#paidNow").val(data.credit_amount);
                $("#current_due_amount").val(current_due_ant.toFixed(2));
                $("#delivery_date").val(data.trans_date);
                $("#remarks").val(data.remarks);
                $("#upId").val(data.id);
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
    $("#paidNow").val(row_total_info.toFixed(2));
    memberDueCal();
});
function memberDueCal() {
    var due_amount= parseFloat($("#due_amount").val());
    var paidNow= parseFloat($("#paidNow").val());
    if(isNaN(due_amount)){ var DueAmnt=0; }else{ var DueAmnt=due_amount; }
    if(isNaN(paidNow)){ var paidNowAmt=0; }else{  var paidNowAmt=paidNow; }

    var currentAmt=(DueAmnt-paidNowAmt);
    $("#current_due_amount").val(currentAmt.toFixed(2));

}

$('#member_name_11').change(function(){
    var member_id=$("#memberid_11").val();
    $("#paidNow").val('0.00');
    $(".payment_ctg_amount").val('');
    $("#current_due_amount").val('0.00');
    $.ajax({
        url:  base_url +"shipment_info/show_member_due_amount/",
        data: {member_id:member_id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){

                $("#due_amount").val(response.data);
                $("#due_amount").attr('readonly',true);

                $("#due_qty").val(response.stock_qty);
                $("#due_qty").attr('readonly',true);


            }else{
                $("#due_amount").val('0.00');
                $("#due_amount").attr('readonly',false);

                $("#due_qty").val('0');
                $("#due_qty").attr('readonly',false);
            }
        }
    });
});
// Member Due Collection
function addCustomerDueCollection() {
    $("#customerDueCollectionForm")[0].reset();
    $("#show_label").html('Save');
    $("#alert_error").hide();
}
$('#customerName_11').change(function(){
    var customer_id=$("#customerID_11").val();
    $("#paidNow").val('0.00');
    $(".payment_ctg_amount").val('');
    $("#current_due_amount").val('0.00');
    $.ajax({
        url:  base_url +"reports/show_customer_due_amount/",
        data: {customer_id:customer_id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            if(response.status=='success'){
                $("#due_amount").val(response.data);
                $("#due_amount").attr('readonly',true);
            }else{
                $("#due_amount").val('0.00');
                $("#due_amount").attr('readonly',false);
            }
        }
    });
});

function saveCustomerDueCollection() {
    $(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"settings/save_customer_due_collection/",
        data: $('#customerDueCollectionForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response.status=='error'){
                $("#alert_error").show();
                $("#show_error_save").html(response.message);
            }else{
                $("#customerDueCollectionForm")[0].reset();
                $('#myModal').modal('hide');
                $("#alert").show();
                $("#show_message").html(response.message);
                setTimeout(function(){
                    window.location = base_url +response.redirect_page;
                },1500);

            }
        }
    });
}

$(document).on("click", ".deleteRowShipment", function (e) {
    if ($('#tableDynamicShipment tr').size() > 1) {
        var target = e.target;

        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var netAmt=parseFloat($("#net_total_"+element_id).val());
        var total_amount=parseFloat($("#total_amount").val());
        if(!isNaN(netAmt)){
            var newTotalAmt=total_amount-netAmt;
            $("#total_amount").val(newTotalAmt.toFixed(2))
        }
        $(target).closest('tr').remove();


    } else {
        //alert('One row should be present in table');
    }
});

$('#delivery_qty').keyup(function(){
    var deliveryQty=parseFloat($("#delivery_qty").val());
    var dueQty= parseFloat($("#due_qty").val());
    if(deliveryQty>dueQty){
        alert('Delivery Qty Must be less than Stock Qty');
        $("#current_stock_qty").val('');
        $("#delivery_qty").val('');

    }else {
        var currentQty = dueQty - deliveryQty;
        $("#current_stock_qty").val(currentQty)
    }

});
function deleteStockInfoInfo(id) {
    var confirmation = confirm("Are you sure you want to delete this information?");
    if (confirmation) {
        $.ajax({
            url: base_url + "shipment_info/deleteShipmentInInfo",
            data: {id: id},
            type: "POST",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                        $('#shipmnetStockInfo').DataTable().ajax.reload();
                    }, 1500);
                } else {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                    }, 3500);
                }
            }
        });
    }
}

function deleteShipmentDelivery(id) {
    var confirmation = confirm("Are you sure you want to delete this information?");
    if (confirmation) {
        $.ajax({
            url: base_url + "shipment_info/delete_shipment_delivery",
            data: {id: id},
            type: "POST",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                        $('#shipmnetDeliveryInfo').DataTable().ajax.reload();
                    }, 1500);
                } else {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                    }, 3500);
                }
            }
        });
    }
}
function deleteDueCollection(id) {
    var confirmation = confirm("Are you sure you want to delete this information?");
    if (confirmation) {
        $.ajax({
            url: base_url + "shipment_info/delete_member_due_collection",
            data: {upId: id},
            type: "POST",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                        $('#shipmnetMemberDueCollectionInfo').DataTable().ajax.reload();
                    }, 1500);
                } else {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                    }, 3500);
                }
            }
        });
    }
}


$(document).on("keyup", ".quantPurchase,.unitPrice ", function (event) {
    var element_id = get_element_id($(this).attr('id'));
    var price = parseFloat($("#unitPrice_" + element_id).val());
    var quantity = parseFloat($("#quantity_" + element_id).val());
    if(isNaN(price)){ var priceAmt=0;   }else{  var priceAmt=price; }
    if(isNaN(quantity)){var quantityAmt=0; }else{ var quantityAmt=quantity;}

    if (!isNaN(priceAmt) && !isNaN(quantityAmt)) {
        var sub_total=(priceAmt * quantityAmt);
        $("#totalPrice_" + element_id).val((sub_total).toFixed(2));
        purchaseTotalCal();

    }else{
        $("#totalPrice_" + element_id).val('0.00');
        purchaseTotalCal();
    }
});

function purchaseTotalCal() {
    if ($("#tableDynamic tr").size() == 0) {
        return $("#net_purchase_amount").val(0);
    }
    $("#tableDynamic tr").each(function () {
        row_total = 0;
        $(".totalPrice").each(function () {
            row_total += Number(parseFloat($(this).val()));
        });
        if (!isNaN(row_total)) {
            $("#net_purchase_amount").val(row_total.toFixed(2));
        }
    });
}

function searchingSalesReport () {
    //$(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"reports/searching_sales_report/",
        data: $('#salesReportForm').serialize(),
        type: "POST",
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response!=''){
                $("#stock_info_data").html(response);
            }
        }
    });
}

function searchingDailySalesStatement () {
    $(".search_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"reports/searchingDailySalesSatement/",
        data: $('#salesReportForm').serialize(),
        type: "POST",
        success: function (response) {
            $(".search_btn").attr("disabled", false);
            if(response!=''){
                $("#stock_info_data").html(response);
            }
        }
    });
}

function deleteSalesInformation(id) {
    var confirmation = confirm("Are you sure you want to remove this Member?");

    if (confirmation) {
        $.ajax({
            url: base_url + "Pos/deleteSalesInfo",
            data: {id: id},
            type: "POST",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                        $('#SalesInfo').DataTable().ajax.reload();
                    }, 1500);
                } else {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                    }, 3500);
                }
            }
        });
    }


}

$(".invoiceNumber").autocomplete({
    source: base_url +'pos/getInvoiceNumber',
    select: function (event, ui) {
        var invoiceNo = ui.item.value;
        $("#salesID").val(invoiceNo);
    }
});


$(document).on("keyup", ".purchaseQtyPrice", function (event) {
    var  price = parseFloat($("#productPurchasePrice").val());
    var  qty = parseFloat($("#purchaseQuantity").val());
    if (!isNaN(price) && !isNaN(qty) ) {
        var sub_total=(price * qty);
        $("#totalPurchaseAmount").val((sub_total).toFixed(2));
    }else{
        $("#totalPurchaseAmount").val('0.00');
    }
});

function deletePurchaseInformation(id) {
    var confirmation = confirm("Are you sure you want to remove this Member?");

    if (confirmation) {
        $.ajax({
            url: base_url + "purchases/deletePurchaseInfo",
            data: {id: id},
            type: "POST",
            dataType: 'JSON',
            success: function (response) {
                if (response.status == 'success') {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                        $('#purchaseInfo').DataTable().ajax.reload();
                    }, 1500);
                } else {
                    $("#alert").show();
                    $("#show_message").html(response.message);
                    setTimeout(function () {
                        $("#alert").hide();
                        $("#show_message").html('');
                    }, 3500);
                }
            }
        });
    }


}


/*
|-----------------------------------------------------------------------------------|
|------------------- for User Access    start---------------------------------------|
|-----------------------------------------------------------------------------------|
*/

function saveUserRole() {
    $("#submitBtn").attr("disabled", true);
    $.ajax({
        url:  base_url +"UserAccessRole/insert_user_role",
        data: $('#userRoleForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $("#submitBtn").attr("disabled", false);
            if(response.status=='error'){
                $("#show_error_save_info").html(response.message);
            }else{
                $("#alert").show();
                $("#show_error_save_info").html(response.message);
                var redirect=response.redirect_page;
                setTimeout(function(){
                    window.location = base_url + redirect;
                },1500);

            }
        }
    });
}

$("#checkAll").click(function(){
    $('input:checkbox').not(this).prop('checked', this.checked);
});

// For Manager Reports
function searchingDailySalesReports () {
    $(".search_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"reports/searchingDailySalesReports/",
        data: $('#salesReportForm').serialize(),
        type: "POST",
        success: function (response) {
            $(".search_btn").attr("disabled", false);
            if(response!=''){
                $("#stock_info_data").html(response);
            }
        }
    });
}
function searchingDailyDetailsSalesReport () {
    //$(".submit_btn").attr("disabled", true);
    $.ajax({
        url:  base_url +"reports/searchingDetailsSalesReport/",
        data: $('#salesReportForm').serialize(),
        type: "POST",
        success: function (response) {
            $(".submit_btn").attr("disabled", false);
            if(response!=''){
                $("#stock_info_data").html(response);
            }
        }
    });
}


var addRowProduct = function (product) {
    console.log(product);
    var productID = $('#productID_'+ product.id).val();
    var productQuantity = parseInt($('#productQuantity_'+ product.id).val());

    if(productID == product.id){
        return $('#productQuantity_'+ product.id).val(productQuantity + 1);
    }

    return $('<tr>\n\
					<td>'+ product.value +'</td>\n\
					<td style="width: 8%;">\n\
						<input id="productQuantity_'+ product.id +'" type="text" class="form-control" name="productQuantity[]" value="1">\n\
						<input type="hidden" class="form-control" name="productName[]" value="'+ product.productName +'">\n\
						<input type="text" class="form-control" name="productType[]" value="'+ product.ProductTypeTitle +'">\n\
						<input type="hidden" class="form-control" name="productCode[]" value="'+ product.productCode +'">\n\
						<input type="hidden" class="form-control" name="productPrice[]" value="'+ product.unit_sale_price +'">\n\
						<input id="productID_'+ product.id +'" type="hidden" class="form-control" name="productID[]" value="'+ product.id +'">\n\
					</td>\n\
					<td style="width: 20%;">'+ product.bandTitle +'</td>\n\
					<td style="width: 2%;">\n\
						<a href="javascript:void(0);" id="removeRow" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>\n\
					</td></tr>').appendTo('#tableDynamic');

};


$( "#productName" ).autocomplete({
    source: base_url+ "purchases/productNameSuggestions",
    response: function (event, ui) {
        if(ui.content){
            if(ui.content.length == 1){
                addRowProduct(ui.content[0]);
                $(this).val('');
                $(this).focus();
                $(this).autocomplete('close');
                return false;
            }
        }

    },
    select: function (event, ui) {
        //console.log(ui);
        addRowProduct(ui.item);
        $(this).val(''); return false;
    }

});

function searchingPurchaseReports () {
    $(".searchBtn").attr("disabled", true);
    $.ajax({
        url:  base_url +"reports/searchingDateWisePurchse/",
        data: $('#purchaseReportForm').serialize(),
        type: "POST",
        success: function (response) {
            $(".searchBtn").attr("disabled", false);
            if(response!=''){
                $("#stock_info_data").html(response);
            }
        }
    });
}

$(".purchaseNumber").autocomplete({
    source: base_url +'Purchases/getPurchaseNumber',
    select: function (event, ui) {
        var invoiceNo = ui.item.value;
        $("#purchaseID").val(invoiceNo);
    }
});

function searchingDetailsPurchaseReports () {
    $(".searchBtn").attr("disabled", true);
    $.ajax({
        url:  base_url +"reports/detailsPurchasePurchseAction/",
        data: $('#purchaseReportForm').serialize(),
        type: "POST",
        success: function (response) {
            $(".searchBtn").attr("disabled", false);
            if(response!=''){
                $("#stock_info_data").html(response);
            }
        }
    });
}

function purchaseSingleUpdate(id) {
    $("#show_error_save_info").html('')
    $("#singleUpdate_"+id).attr("disabled", true);
    $('#purchaseProductModal').modal({
        show: 'false'
    });
    $.ajax({
        url:  base_url +"purchases/get_purchase_single_item_info/",
        data: {id:id},
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $("#singleUpdate_"+id).attr("disabled", false);
            if(response.status=='error'){
                alert(response.message);
            }else{
                $("#updateSinglePurchaseItemForm")[0].reset();
                var data=response.data;
                $("#productInfo").val(data.product_name +' ['+data.productCode+']');
                $("#productID").val(data.id);
                $("#purchaseID").val(data.purchase_id);
                $("#singleQty").val(data.total_item);
                $("#singleUnitPrice").val(data.unit_price);
                $("#singleTotalPrice").val(data.total_price);
            }
        }
    });
}

function updateSinglePurchaseItem() {
    $("#singleUpdateBtn").attr("disabled", true);
    $.ajax({
        url:  base_url +"purchases/updateSinglePurchaseItem/",
        data: $('#updateSinglePurchaseItemForm').serialize(),
        type: "POST",
        dataType:'JSON',
        success: function (response) {
            $("#singleUpdateBtn").attr("disabled", false);
            if(response.status=='error'){
                $("#show_error_save_info").html(response.message);
            }else{
                $('#purchaseProductModal').modal('toggle');

                setTimeout(function(){
                    alert(response.message);
                    window.location = base_url + response.redirect_page;
                },1500);

            }
        }
    });
}

$(document).on("keyup", ".purchase_single_item_change", function (event) {
    var  price = parseFloat($("#singleUnitPrice").val());
    var quantity = parseFloat($("#singleQty").val());
    if (!isNaN(price) && !isNaN(quantity)  ) {
        var sub_total=(price * quantity);
        $("#singleTotalPrice").val((sub_total).toFixed(2));
    }else{
        $("#singleTotalPrice").val('0.00');
    }
});

$('.changeSearchProduct').click(function(){
    $.ajax({
        url:  base_url +"purchases/searchPurchaseProductAction/",
        data: $('#purchaseInfoForm').serialize(),
        type: "POST",
        // dataType:'JSON',
        success: function (response) {
            if(response !==''){
                $(".showReports").html(response);
            }else{
                $(".showReports").html('');
            }
        }
    });
});
