<style>
    .table-style td{
        padding: 7px;
    }
    .table-style-main td{
        padding: 5px;
        border:1px solid #d0d0d0;
    }
    .table-style-main th{
        padding: 7px;
        border:1px solid #d0d0d0;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <?php if ($this->session->flashdata('msg')) { ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('msg'); ?>
        </div>
    <?php } ?>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Update Purchase</h3>
                    <div class="row pull-right">
                        <div class="col-xs-12 pull-right">
                            <a class="btn btn-danger btn-xs pull-right no-print" style="margin-right:5px;" href="<?php echo site_url('purchases/index') ?>"><i class="glyphicon glyphicon-backward"></i> Back</a>
                            <a class="btn btn-info btn-xs pull-right no-print" style="margin-right:5px;" href="<?php echo site_url('purchases/show/'.$this->uri->segment(3)); ?>"><i class="glyphicon glyphicon-pencil"></i> View</a>
                        </div>
                    </div>
                </div><!-- /.box-header -->
                <!-- form start -->

                <form action="<?php echo site_url('purchases/update'); ?>" method="POST" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div id="select_box">
                                        <label>Supplier<sup>*</sup></label>
<!--                                        <input type="text" id="supplierName" value="--><?php //echo $edit_info1['supplierName'] ; ?><!-- " placeholder="Supplier Name" class="form-control" required>-->
<!--                                        <input type="hidden" name="supplierID" value="--><?php //echo $edit_info1['supplierID']  ?><!--" id="supplierID"/>-->
                                        <select name="supplierID" id="supplierID" class="form-control">
                                            <option>Select Supplier Name</option>
                                            <?php
                                            foreach($get_all_supplier as $supplier){
                                                $select=($edit_info1['supplierID']==$supplier->supplierID)?"selected":"";
                                                echo "<option value='$supplier->supplierID'".$select.">$supplier->supplierName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Purchase No.</label>
                                    <input name="purchaseNo" value="<?php echo $edit_info1['purchaseNo']; ?>" type="text" readonly  class="form-control">
                                </div>                           
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Purchase Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="purchaseDate" id="datepicker_no_one"  value="<?php echo $edit_info1['purchaseDate'] ?>" class="form-control" placeholder="YYYY-MM-DD"> <!-- For Limit Today:  data-provide="datepicker" data-date-end-date="0d" -->
                                    </div>

                                </div>                           
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Due Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="dueDate" id="datepicker_no_two" value="<?php echo $edit_info1['dueDate'] ?>" class="form-control" placeholder="YYYY-MM-DD">
                                    </div>

                                </div>                           
                            </div>
                        </div> 

                        <div class="clearfix"></div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PO Reference</label>
                                    <input name="poRef" type="text" value="<?php echo $edit_info1['poRef'] ?>" placeholder="Po / Reference" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Payment Terms</label>
                                    <input name="payTerms" value="<?php echo $edit_info1['payTerms'] ?>" type="text" placeholder="Payment Terms" class="form-control">
                                </div>
                            </div>
                            <input type="hidden" name="warehouseID" value="4">
                        </div>

                        <div>
                            <table class="table-style-main" class="table table-striped">
                                <thead>
                                    <tr>
                                        <td colspan="7" style="font-weight: bold;">Products Information</td>
                                    </tr>
                                    <tr>
                                        <th style="width: 3%;">SL.</th>
                                        <th>Product Name</th>
                                        <th style="width: 10%;">Quantity</th>
                                        <th style="width: 10%;">Unit</th>
                                        <th style="width: 12%;">Purchase Price</th>
                                        <th style="width: 11%;">Total Price</th>
                                        <th style="width: 6%;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tableDynamic">

                                    <?php
                                    $i = 1;
                                    foreach ($edit_info as $key => $each_item) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php
                                                $product_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_products', 'productID', $each_item['productID']);
                                                ?>
                                                <input type="text" id="productName_<?php echo $key; ?>" value="<?php echo $product_name['productName']?>" data-type="productName" placeholder="Product Name" class="productName form-control">
                                                <input type="hidden" name="productID[]" id="productID_<?php echo $key; ?>" value="<?php echo $each_item['productID']?>" class="form-control">
                                            </td>
                                            <td><input type="text" name="quantity[]" id="quantity_<?php echo $key; ?>" value="<?php echo $each_item['quantity']?>" placeholder="Quantity" class="quant form-control only-number"></td>
                                            <td>
                                                <select name="unit[]"  id="unit_<?php echo $key; ?>" class="purchaseUnit form-control">
                                                    <?php ?>
                                                    <option value=""> Unit</option><?php foreach($getProductUnit as $unit) {$selected=($each_item['unit_id']==$unit->id)?"selected":"";  echo "<option value='$unit->id'".$selected.">$unit->title</option>";} ?></select>
                                            </td>
                                            <td><input type="text" name="purchasePrice[]"  placeholder="Purchase Price" id="unitcost_<?php echo $key; ?>" value="<?php echo $each_item['purchasePrice']?>"  class="purchaseprice form-control only-number"></td>

                                            <td><input type="text" id="totalprice_<?php echo $key; ?>" value="<?php echo $valueofprice = $each_item['quantity'] *  $each_item['purchasePrice']?>" name="totalPrice[]"  readonly placeholder="Total Price.." class="totalprice form-control"></td>
                                            <td><a href="javascript:void(0);" id="deleteRow_<?php echo $key; ?>"  class="deleteRow btn btn-danger btn-flat btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                            <table class="table">
                                <tr>
                                    <td style="width:70%">
                                        <table>
                                            <tr>
                                                <a href="javascript:void(0);" id="addRow" class="btn btn-info btn-flat btn-sm"><i class="glyphicon glyphicon-plus"></i> Add Product</a>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="">Note<sup>*</sup></label>
                                                    <textarea class="textarea" name="note"  placeholder="Note" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $edit_info1['note'] ?></textarea>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                    <td style="width:30%">
                                        <table style="width:100%;" class="table-style">
                                            <tr>
                                                <th style="text-align: right;width: 30%;" colspan="">Sub Total</th>
                                                <td> <input name="subTotal" type="text" id="subtotal" value="<?php echo $edit_info1['subTotal'] ?>" readonly placeholder="Sub Total Price.." class="form-control"></td></td>
                                            </tr>
                                            <tr>

                                                <th style="text-align: right;" colspan="">Discount</th>
                                                <td style="border-top: medium none;" > <input type="text" name="discount" id="discount" value="<?php echo $edit_info1['discount'] ?>"  name="discount" placeholder="Discount.." class="form-control" value="0"></td>
                                            </tr>


                                            <tr>
                                                <th style="border-top: medium none; text-align: right;" colspan="">Net Total</th>
                                                <td style="border-top: medium none;">  <input  type="text" id="net_total" name="netTotal"  value="<?php echo $edit_info1['netTotal'] ?>" readonly placeholder="Net Total.." class="form-control"></td>
                                            </tr>
                                            <tr>
                                                <th style="border-top: medium none; text-align: right;" colspan="">Due Amount</th>
                                                <td style="border-top: medium none;"><input type="text" id="dueamount"  readonly value="<?php echo $edit_info1['dueAmount'] ?>"  name="dueAmount" placeholder="Due Amount.." class="form-control"></td>
                                            </tr>

                                        </table>
                                    </td>

                                </tr>
                            </table>

                        </div>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary btn-flat"  onclick="return checkadd();">Update Purchase</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>

</section>
<!-- /.content -->


<script type="text/javascript">


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

    
    // Random String Function
    var randomString = function(length) {
        var text = "";
        var possible = "0123456789";
        for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    // Document Ready Function
    $(function() {
        $("#purchaseNo").val('PUR-'+randomString(3));
    });

    // Supplier Name
    $("#supplierName").autocomplete({
        source: '<?php echo site_url('Purchases/supplierNameSuggestions')?>',
        select: function (event, ui) {
            $("#supplierName").val(ui.item.value);
            $("#supplierID").val(ui.item.id);
            return false;
        }
    });

    // Warehouse
    $("#warehouseName").autocomplete({
        source: '<?php echo site_url('Purchases/warehouseNameSuggestions')?>',
        select: function (event, ui) {
            $("#warehouseName").val(ui.item.value);
            $("#warehouseID").val(ui.item.id);
            return false;
        }
    });

    // Product Name
    $(".productName").autocomplete({
        source: "<?php echo site_url('Purchases/productNameSuggestions')?>",
        select: function (event, ui) {
            var id_arr = $(this).attr('id');
            var id = id_arr.split("_");
            var element_id = id[id.length - 1];

            $("#productName_"+element_id).val(ui.item.value);
            $("#productID_"+element_id).val(ui.item.id);
            return false;
        }
    });



    var scntDiv = $('#tableDynamic');
    var i = $('#tableDynamic tr').size() + 1;

    
    
    $('#addRow').on('click', function () {
        $('<tr><td>' + i + '</td><td><input type="text" id="productName_' + i + '" data-type="productName"  placeholder="Product Name" class="productName form-control"><input type="hidden" name="productID[]" id="productID_' + i + '"  class="productid form-control"></td><td><input type="text" name="quantity[]" id="quantity_' + i + '"  placeholder="Quantity" class="quant form-control only-number"></td><td><select  required name="unit[]"   id="unit_' + i + '" class="purchaseUnit form-control"><option value="">Unit</option><?php foreach($getProductUnit as $unit) {?> <option value="<?php echo $unit->id ?>"> <?php echo $unit->title ?></option> <?php } ?></select></td><td><input type="text"  name="purchasePrice[]"  placeholder="Purchasing Price" id="unitcost_' + i + '" class="purchaseprice form-control only-number"></td><td><input type="text" id="totalprice_' + i + '"   name="totalPrice[]" readonly placeholder="Total Price.." class="totalprice form-control"></td><td><a href="javascript:void(0);" id="deleteRow_' + i + '"  class="deleteRow btn btn-danger btn-flat btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td></tr>').appendTo(scntDiv);

                    // Product Name
                    $(".productName").autocomplete({
                        source: "<?php echo site_url('Purchases/productNameSuggestions');?>",
                        select: function (event, ui) {
                         
                            var id_arr = $(this).attr('id');
                            var id = id_arr.split("_");
                            var element_id = id[id.length - 1];
                            $("#productName_" + element_id).val(ui.item.value);
                            $("#productID_" + element_id).val(ui.item.id);
                            return false;
                        }
                    });

                    i++;

                    return false;
                });


                $(document).on("click", ".deleteRow", function (e) {
                    if ($('#tableDynamic tr').size() > 1) {
                        var target = e.target;

                        var id_arr = $(this).attr('id');
                        var id = id_arr.split("_");
                        var element_id = id[id.length - 1];

                        var totalprice = parseFloat($("#totalprice_" + element_id).val());

                        var subtotal = parseFloat($("#subtotal").val());
                        var net_total = parseFloat($("#net_total").val());
                        var dueamount = parseFloat($("#dueamount").val());

                        if (!isNaN(totalprice)) {

                            $("#subtotal").val(subtotal - totalprice);
                            $("#net_total").val(net_total - totalprice);
                            $("#dueamount").val(dueamount - totalprice);



                            var subtotal = parseFloat($("#subtotal").val());
                            var discount = parseFloat($("#discount").val());

                            $("#net_total").append().val(subtotal - discount);
                            $("#dueamount").append().val(subtotal - discount);
                        }

                        $(target).closest('tr').remove();


                    } else {
                        //alert('One row should be present in table');
                    }
                });


                $(document).on("keyup", ".purchaseprice", function (event) {
                    var unitprice = $(this).val();
                   
                    var id_arr = $(this).attr('id');
                    var id = id_arr.split("_");
                    var element_id = id[id.length - 1];
                    var total = unitprice * $("#quantity_" + element_id).val();
                    //        var vatamount = total * $("#vat_rate_" + element_id).val() / 100;

                    $("#totalprice_" + element_id).val(total);
                    //        $("#vatamount_" + element_id).val(vatamount);

                    function findTotals() {
                        $("#tableDynamic tr").each(function () {
                            row_total = 0;
                            //                row_total2 = 0;
                            $("td .totalprice").each(function () {
                                row_total += Number($(this).val());
                            });
                            //                $("td .vatamount").each(function () {
                            //                    row_total2 += Number($(this).val());
                            //                });
                            $("#subtotal").append().val(row_total);
                            //                $("#vat_ttl").append().val(row_total2);

                        });
                    }
                    row = findTotals();

                    var subtotal = parseFloat($("#subtotal").val());
                    var discount = parseFloat($("#discount").val());


                    //        var vat_ttl = parseFloat($("#vat_ttl").val());
                    //        $("#vat_ttl").append().val(vat_ttl);
                    //        $("#grandtotal").append().val(subtotal + vat_ttl);
                    $("#net_total").append().val(subtotal - discount);
                    $("#dueamount").append().val(subtotal - discount);
                });

                $(document).on("keyup", ".quant", function (event) {
                    var quantity = $(this).val();
                    var id_arr = $(this).attr('id');
                    var id = id_arr.split("_");
                    var element_id = id[id.length - 1];
                    var total = quantity * $("#unitcost_" + element_id).val();
                    //        var vatamount = total * $("#vat_rate_" + element_id).val() / 100;

                    $("#totalprice_" + element_id).val(total);
                    //        $("#vatamount_" + element_id).val(vatamount);

                    function findTotals() {
                        $("#tableDynamic tr").each(function () {
                            row_total = 0;
                            //                row_total2 = 0;
                            $("td .totalprice").each(function () {
                                row_total += Number($(this).val());
                            });
                            //                $("td .vatamount").each(function () {
                            //                    row_total2 += Number($(this).val());
                            //                });
                            $("#subtotal").append().val(row_total);
                            //                $("#vat_ttl").append().val(row_total2);

                        });
                    }
                    row = findTotals();

                    var subtotal = parseFloat($("#subtotal").val());
                    var discount = parseFloat($("#discount").val());

                    $("#net_total").append().val(subtotal - discount);
                    $("#dueamount").append().val(subtotal - discount);
                });



                $(document).on("keyup", "#discount", function (event) {
                    var discount = $(this).val();
                    //console.log(discount);
                    var subtotal = parseFloat($("#subtotal").val());
                    var dueamount = parseFloat($("#dueamount").val());


                    $("#net_total").append().val(subtotal - discount);
                    $("#dueamount").append().val(subtotal - discount);
                });




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
