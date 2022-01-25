
<?php
$client_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_clients', 'clientID', $edit_info1['clientID']);
$store_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_warehouses', 'warehouseID', $edit_info1['warehouseID']);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <?php if ($this->session->flashdata('msg')) { ?>

        <div class="alert box alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>  


    <?php } ?>

</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Sale</h3>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url('sales/update'); ?>" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Client Name</label>
                                    <input type="text"  id="clientName" value="<?php echo $client_name['clientName'] ?>" class="form-control" placeholder="Client Name">
                                    <input  value="<?php echo $edit_info1['warehouseID']; ?>" name="warehouseid" type="hidden">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Warehouse Name</label>
                                    <input type="text" readonly="" value="<?php echo $store_name['warehouseName']; ?>" class="form-control" placeholder="Warehouse Name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Invoice Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="invoiceDate" id="datepicker" value="<?php echo $edit_info1['invoiceDate']; ?>" class="form-control" placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Sales Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="salesDate" id="datepicker2" value="<?php echo $edit_info1['salesDate']; ?>" class="form-control" placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Invoice No</label>
                                    <input  readonly=""  name="invoiceNo" value="<?php echo $edit_info1['invoiceNo']; ?>"  class="form-control" placeholder="Invoice No">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>PO Reference</label>
                                    <input value="<?php echo $edit_info1['poRef'] ?>" name="poRef" class="form-control" placeholder="PO Reference">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Payment Terms</label>
                                    <input value="<?php echo $edit_info1['payTerms']; ?>" name="payTerms" class="form-control" placeholder="Payment Terms">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Delivery Place </label>
                                    <input value="<?php echo $edit_info1['deliveryPlace']; ?>" name="deliveryPlace" class="form-control" placeholder="Delivery Place">
                                </div>
                            </div>

                        </div>
                        <div class="row" style="padding: 30px 0px;">
                            <div class="col-md-3">
                                <b> Search Product By Name or Barcode </b>
                            </div>
                            <div class="col-md-9">
                                <input value="" id="productName" class="form-control" placeholder="Search Product By Name or Barcode">
                            </div>
                        </div>
                        <div class="box-header">
                            <h3 class="box-title">Products *</h3>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th style="width: 12%;">Whole Sale Price</th>
                                            <th style="width: 10%;">Quantity</th>
                                            <th style="width: 11%;">Total Price</th>
                                            <th style="width: 6%;">#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDynamic">
                                        <?php foreach ($edit_info as $key => $each_item) { ?>
                                            <tr>
                                                <td style="text-align: left;">
                                                    <?php
                                                    $product_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_products', 'productID', $each_item['productID']);
                                                    echo $product_name['productName'];
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php echo $each_item['price']; ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <input id="qty_<?php echo $key; ?>" type="text" class="quantity form-control" name="qty[]" style="padding:5px;text-align: center;" value="<?php echo $each_item['quantity'] ?>" autocomplete="off">
                                                    <input id="productID_<?php echo $key; ?>" name="productID[]" value="<?php echo $each_item['productID'] ?>" type="hidden">
                                                    <input id="inventory_<?php echo $key; ?>" value="" type="hidden">
                                                    <input id="price_<?php echo $key; ?>" name="price[]" value="<?php echo $each_item['price']; ?>" type="hidden">
                                                </td>
                                                <td class="totalprice"  style="text-align: center;" id="total_<?php echo $key; ?>">
                                                    <?php echo $each_item['price']; ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <div id="removeRow">
                                                        <i class="fa fa-trash-o" style="cursor:pointer;">
                                                        </i>
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">

                            </div>
                            <div class="col-md-4">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td><b>Sub Total</b></td>
                                            <td><input readonly="" value="<?php echo $edit_info1['subTotal']; ?>" id="subTotal" name="subTotal" class="form-control" placeholder="Sub Total"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Vat</b></td>
                                            <td>
                                                <input readonly="" id="vat" name="vat" value="<?php echo $edit_info1['vat']; ?>" class="form-control" placeholder="Vat">
                                                <input type="hidden" id="vatRate" name="vatRate" value="<?php echo $config->vatRate; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Grand Total</b></td>
                                            <td><input readonly="" value="<?php echo $edit_info1['grandTotal']; ?>" id="grand" name="grandTotal" class="form-control" placeholder="Grand Total"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Discount</b></td>
                                            <td><input id="discount" value="<?php echo $edit_info1['discount']; ?>" name="discount" class="form-control" placeholder="Discount"></td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Total</b></td>
                                            <td><input readonly="" id="net" value="<?php echo $edit_info1['netTotal']; ?>" name="netTotal" class="form-control" placeholder="Net Total"></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><button type="submit" class="btn btn-block btn-primary btn-flat" onclick="return checkadd();">Update Sale</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var randomString = function(length) {
        var text = "";
        var possible = "0123456789";
        for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    var addRowProduct = function (id,inventory,price,value,warehouseID,code) {
        var productID = parseFloat($('#productID_'+id).val());
        var productQuantity = parseInt($('#qty_'+ id).val());
        var productInventory = parseFloat($("#inventory_" + id).val());
        var productPrice = parseFloat($("#price_" + id).val());
        if(productID == id){
              
            if(productInventory >= productQuantity + 1){
                $('#qty_'+ id).val(productQuantity + 1);
              
                if (!isNaN(productPrice)) {
                    var total = (productQuantity + 1) * productPrice;
                    $('#total_'+ id).text(total);  
                }
                return findTotal();
              
            }else{
                return findTotal();
                
            }

        }

        $('<tr><td style="text-align: left;">'+ value +' ('+ code +')</td><td style="text-align: center;">'+ price +'</td><td style="text-align: center;"><input id="qty_'+id+'" type="text" class="quantity form-control" name="qty[]" style="padding:5px;text-align: center;" value="1" autocomplete="off"><input id="productID_'+id+'" name="productID[]" value="'+id+'" type="hidden"><input id="inventory_'+id+'" value="'+inventory+'" type="hidden"><input id="price_'+id+'" name="price[]" value="'+price+'" type="hidden"></td><td class="totalprice" style="text-align: center;" id="total_'+id+'">'+ price*1 +'</td><td style="text-align: center;"><div id="removeRow"><i class="fa fa-trash-o" style="cursor:pointer;"></i></div></td></tr>').appendTo('#tableDynamic');

        return findTotal();
    };

    var findTotal = function () {
        if ($("#tableDynamic tr").size() == 0){
            return $("#subTotal").val(0);
        }
        $("#tableDynamic tr").each(function() {
            row_total = 0;
            $(".totalprice").each(function() {
                  
                row_total += Number(parseFloat($(this).text()));
            });
            $("#subTotal").val(row_total);
           
            var vatRate = parseFloat($("#vatRate").val());
            var vatAmount = row_total / 100 * vatRate;
            $("#vat").val(vatAmount);
            
            //            alert(vatRate);
            
            $("#grand").val(vatAmount + row_total);
            var discount = parseFloat($("#discount").val());
            if(isNaN(discount)){
                discount = 0;
            }
            return $("#net").val(vatAmount + row_total - discount);

        });
    };



    $("#invoiceNo").val('SALE-'+randomString(3));

    // Client Name
    $("#clientName").autocomplete({
        source: '<?php echo base_url('sales'); ?>/suggestionClientName',
        select: function (event, ui) {
            $("#clientName").val(ui.item.value);
            $("#clientID").val(ui.item.id);
            return false;
        }
    });

    	    

    // Product Name
    $( "#productName" ).autocomplete({
                        
        source: <?php echo $jsonProduct; ?>,
        response: function (event, ui) {
            if(ui.content){
                if(ui.content.length == 1){
                
                    addRowProduct(ui.content[0].id,ui.content[0].inventory,ui.content[0].productWholeSalePrice,ui.content[0].productName,ui.content[0].warehouseID,ui.content[0].productCode);
                    $(this).val(''); 
                    $(this).focus();
                    $(this).autocomplete('close');
                    return false;
                }else if(ui.content.length == 0){
                    $(this).val(''); 
                    $(this).focus();
                    $(this).autocomplete('close');
                    return false;
                }else{

                }
            }
        },
        select: function (event, ui) {
            addRowProduct(ui.item.id,ui.item.inventory,ui.item.productWholeSalePrice,ui.item.productName,ui.item.warehouseID,ui.item.productCode);
            $(this).val(''); return false;
        }

    });

    $(document).on("click", "#removeRow", function(e) {
        var target = e.target;
        $(target).closest('tr').remove();
        $('#discount').val('');
        findTotal();
          
          
    });

    $(document).on("keyup", ".quantity", function (event) {
        var quantity = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
//         alert(element_id);
        
        var inventory = parseFloat($("#inventory_" + element_id).val());
        var price = parseFloat($("#price_" + element_id).val());
        //        alert(price);
        if(!isNaN(quantity)){
            if(quantity > inventory){
                $("#total_"+element_id).text("");
                $( this ).css( "border", "2px solid red" );
                findTotal();
            }else{
                $("#total_"+element_id).text(price*quantity);
                
                $( this ).css( "border", "1px solid #ddd" );
                findTotal();
            }
        }else{
            $("#total_"+element_id).text("");
        }
    });
    
    $('#discount').keyup(function () {
        findTotal();
    });
    
    var today = new Date();  
    var dd = today.getDate();  
    var mm = today.getMonth()+1;   
    var yyyy = today.getFullYear();  
    if(dd<10)   
    {  
        dd='0'+dd;  
    }   
          
    if(mm<10)   
    {  
        mm='0'+mm;  
    }   
    today = yyyy+'-'+mm+'-'+dd;  
    $("#datepicker").val(today);
    $("#datepicker2").val(today);
    
    function checkadd() {
        var chk = confirm("Are you sure to add this record ?");
        if (chk) {
            return true;
        } else {
            return false;
        }
        ;
    }
    
</script>