<style>
    #tableInfo tr th {
        text-align: center;
        border: 1px solid lightgray !important;
    }

    #tableInfo tr td {
        text-align: center;
        border: 1px solid lightgray !important;
        margin: 2px !important;
        padding: 2px !important;
    }

    .input_style {
        width: 100px !important;
        margin: 5px !important;
        height: 25px;
    }

    .input_style_select {
        width: 100px !important;
        height: 30px;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box no-border">
                <div class="box-header with-border">
                    <div class="col-sm-4"><h3 class="box-title"><?php echo $title; ?></h3></div>
                    <div class="col-sm-8 no-print">

                        <a href="<?php echo site_url('inventory/stockReports'); ?>"
                           class="btn btn-danger btn-xs pull-right" title="Add"><i
                                    class="glyphicon glyphicon-backward"></i> Back </a>
                        <button class="btn btn-info btn-xs pull-right" style="margin-right:10px;"
                                onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print
                        </button>
                    </div>
                </div>
                <div class="box-body no-border">
                    <div class=" col-sm-12">
                        <form class="form-horizontal" action="<?php echo base_url('inventory/stockUpdateAction'); ?>"
                              method="post">
                            <div class="row">
                                <div class="col-sm-3 col-lg-3" style="margin-bottom: 10px;">
                                    <label>Entry Date</label>
                                    <input name="entry_date" value="<?php echo $get_log_date_info->log_date ?>"
                                           id="datepicker" class="form-control" placeholder="YYYY-MM-DD"
                                           style="width:100% !important;">
                                </div>
                                <div class=" col-xs-7">
                                    <label>Note</label>
                                    <textarea name="note" placeholder="Enter Stock Note" class="form-control" rows="1"
                                              style="width:100% !important;"><?php echo $get_log_date_info->note ?></textarea>
                                </div>
                                <input type="hidden" value="<?php echo $get_log_date_info->log_id; ?>" name="log_id"
                                       class="form-control">
                                <div class="col-xs-2">
                                    <br/>

                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <table id="tableInfo" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Product</th>
                                    <th>Previous Qty</th>
                                    <th>Purchase Qty</th>
                                    <th>Current Qty</th>
                                    <th>Use Qty</th>
                                    <th>Wasted Qty</th>
                                    <th>Final Qty</th>
                                    <th>Unit</th>
                                    <th>#</th>
                                </tr>

                                </thead>
                                <input type="hidden" id="total_count_product" value="<?php echo  count($get_all_used_detais); ?>">
                                <?php

                                $i = 1;

                                if (!empty($get_all_used_detais)){
                                foreach ($get_all_used_detais as $row){
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <input type="hidden" name="product_id[]" value="<?php echo $row->product_id ?>">
                                    <td><input type="text"
                                               value="<?php echo $row->productName . "[" . $row->productCode . "]"; ?>"
                                               readonly class="form-control "></td>
                                    <td><input type="text" value="<?php echo $row->previous_qty; ?>"
                                               name="previous_qty[]" id="previous_qty_<?php echo $i; ?>"
                                               class="form-control previous_qty input_style only-number"></td>
                                    <td><input type="text" value="<?php echo $row->today_purchase_qty; ?>" readonly
                                               name="today_purchase_qty[]" id="today_purchase_qty_<?php echo $i; ?>"
                                               class="form-control today_purchase_qty input_style only-number"></td>
                                    <td><input type="text" value="<?php echo $row->today_final_stock_qty; ?>"
                                               name="today_final_stock_qty[]"
                                               id="today_final_stock_qty_<?php echo $i; ?>"
                                               class="form-control today_final_stock_qty input_style only-number"></td>
                                    <td><input type="text" value="<?php echo $row->today_use; ?>" name="today_use_qty[]"
                                               id="today_use_qty_<?php echo $i; ?>"
                                               class="form-control today_use_qty input_style only-number"></td>
                                    <td>
                                        <input type="text" name="wasted_qty[]" id="wasted_qty_<?php echo $i; ?>"
                                               value="<?php echo $row->today_wasted; ?>"
                                               class="form-control wasted_qty input_style only-number input_style">
                                    </td>
                                    <td><input type="text" value="<?php echo $row->current_qty; ?>" name="current_qty[]"
                                               id="current_qty_<?php echo $i; ?>"
                                               class="form-control current_qty input_style only-number"></td>
                                    <td>
                                        <select name="unit[]" id="unit_<?php echo $i; ?>"
                                                class="purchaseUnit form-control input_style_select">
                                            <option value=""> Unit</option>
                                            <?php
                                            foreach ($getProductUnit as $unit) {
                                                $selected = ($row->unit_id == $unit->id) ? "Selected" : '';
                                                echo "<option value='$unit->id'" . $selected . ">$unit->title</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" id="deleteRow_' <?php echo $i; ?> '"  class="deleteRow btn btn-danger btn-flat btn-sm"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>

                                    <input type="hidden" value="<?php echo $row->id; ?>" name="id[]"
                                           class="form-control">
                                    <?php $i++;
                                    }
                                    }
                                    ?>
                                    <tbody id="tableDynamic">
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="10" style="text-align:left;"><a href="javascript:void(0);" id="addRow"
                                                           class="btn btn-info btn-sm"><i
                                                        class="glyphicon glyphicon-plus"></i> Add New</a></td>
                                    </tr>

                                    </tfoot>
                            </table>
                            <button type="submit" name="updateBtn" class="btn btn-success pull-right"><i
                                        class="glyphicon glyphicon-ok"></i> Update Stock
                            </button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>
</section>

<script>
    $(document).on("keyup", ".today_use_qty", function (event) {
        var today_use_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var previous_qty = parseFloat($("#previous_qty_" + element_id).val());
        var today_purchase_qty = parseFloat($("#today_purchase_qty_" + element_id).val());
        var wasted_qty = parseFloat($("#wasted_qty_" + element_id).val());
        var final_stock = previous_qty + today_purchase_qty
        if (!isNaN(final_stock)) {
            $("#current_qty_" + element_id).val(final_stock - (today_use_qty + wasted_qty));
        }
    });
    $(document).on("keyup", ".previous_qty", function (event) {
        var previous_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var today_use_qty = parseFloat($("#today_use_qty_" + element_id).val());
        var today_purchase_qty = parseFloat($("#today_purchase_qty_" + element_id).val());
        var final_stock = previous_qty + today_purchase_qty
        if (!isNaN(final_stock)) {
            $("#today_final_stock_qty_" + element_id).val(final_stock);
            $("#current_qty_" + element_id).val(final_stock - today_use_qty);
        }
    });
    $(document).on("keyup", ".today_purchase_qty", function (event) {
        var today_purchase_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var today_use_qty = parseFloat($("#today_use_qty_" + element_id).val());
        var previous_qty = parseFloat($("#previous_qty_" + element_id).val());
        var final_stock = previous_qty + today_purchase_qty
        if (!isNaN(final_stock)) {
            $("#today_final_stock_qty_" + element_id).val(final_stock);
            $("#current_qty_" + element_id).val(final_stock - today_use_qty);
        }
    });

    $(document).on("keyup", ".wasted_qty", function (event) {
        var today_wasted_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var today_final_stock_qty = parseFloat($("#today_final_stock_qty_" + element_id).val());
        var today_use_qty = parseFloat($("#today_use_qty_" + element_id).val());
        var final_stock = today_final_stock_qty - (today_use_qty + today_wasted_qty);
        if (!isNaN(final_stock)) {
            $("#current_qty_" + element_id).val(final_stock);
        }
    });


    // for edit product information
    var total_present_product=parseFloat($("#total_count_product").val())+1;
    var scntDiv = $('#tableDynamic');
    var i = $('#tableDynamic tr').size() + total_present_product;
    $('#addRow').on('click', function () {
        $('<tr>\n\
            <td>' + i + '</td>\n\
            <td>\n\
                <input type="text" required id="productName_' + i + '" data-type="productName"  placeholder="Product Name" class="productName form-control">\n\
                <input type="hidden" name="product_id[]" id="productID_' + i + '"  class="productid form-control">\n\
            </td>\n\
            <td><input type="text" name="previous_qty[]" id="previous_qty_' + i + '"  value="0.00"  class="form-control previous_qty input_style only-number"></td>\n\
            <td><input type="text" name="today_purchase_qty[]" id="today_purchase_qty_' + i + '"  value="0.00"  class="form-control today_purchase_qty input_style only-number"></td>\n\
            <td><input type="text" name="today_final_stock_qty[]" id="today_final_stock_qty_' + i + '"  value="0.00"  class="form-control today_final_stock_qty input_style only-number"></td>\n\
            <td><input type="text" name="today_use_qty[]" id="today_use_qty_' + i + '"  value="0.00"  class="form-control today_use_qty input_style only-number"></td>\n\
            <td><input type="text" name="wasted_qty[]" id="wasted_qty_' + i + '"  value="0.00"  class="form-control wasted_qty input_style only-number"></td>\n\
            <td><input type="text" name="current_qty[]" id="current_qty_' + i + '"  value="0.00"  class="form-control current_qty input_style only-number"></td>\n\
            <td>\n\
                <select  required name="unit[]"  required id="unit_' + i + '" class="purchaseUnit form-control input_style_select"><option value="">Unit</option><?php foreach($getProductUnit as $unit) {?> <option value="<?php echo $unit->id ?>"> <?php echo $unit->title ?></option> <?php } ?></select>\n\
            </td>\n\
            <td>\n\
                <a href="javascript:void(0);" id="deleteRow_' + i + '"  class="deleteRow btn btn-danger btn-flat btn-sm"><i class="glyphicon glyphicon-remove"></i></a>\n\
            </td>\n\
        </tr>').appendTo(scntDiv);

        // Product Name
        $(".productName").autocomplete({
            source: "<?php echo site_url('purchases/productNameSuggestions'); ?>",
            select: function (event, ui) {
                var id_arr = $(this).attr('id');
                var id = id_arr.split("_");
                var element_id = id[id.length - 1];
                $("#productName_" + element_id).val(ui.item.value);
                $("#productID_" + element_id).val(ui.item.id);

                var inventory_date=$("#datepicker").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>Inventory/get_inventory_stock/",
                    data: {product_id:ui.item.id,inventory_date:inventory_date},
                    dataType: 'json',
                    success: function (data) {
                        $("#previous_qty_"+ element_id ).val(data.previous_product_qty);
                        $("#today_purchase_qty_"+ element_id ).val(data.totay_purchase);
                    }
                });

                return false;
            }
        });

        i++;

        return false;
    });


    $(document).on("click", ".deleteRow", function (e) {
        var target = e.target;
        $(target).closest('tr').remove();
    });
</script>	
