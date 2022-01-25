<style>
   #tableInfo tr th{
       text-align: center;
       border:1px solid lightgray!important;
   }
    #tableInfo tr td{
        text-align: center;
        border:1px solid lightgray!important;
        margin: 2px!important;
        padding: 2px!important;
    }
	input{
		width:80% !important;

	}
   .input_style{
       width:100px !important;
       margin:5px !important;
       height:25px;
   }
   .input_style_select{
       width:100px !important;
       height:30px;
   }
</style>
<?php 
extract($_POST);
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daily Stock Entry </h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                    <a href="<?php echo site_url('inventory/stockReports'); ?>" class="btn btn-primary btn-xs pull-right" title="Add"><i class="glyphicon glyphicon-list"></i> View Report</a>
                </div>
                <div class="box-body">
					<div class="col-sm-12">
						<form class="form-horizontal"  action="" method="post">
							<div class="row">
									<div class="col-sm-3 col-lg-3" style="margin-bottom: 10px;">
										<label>Searching Purchase Date</label>
									</div>
									<div class="col-sm-3 col-lg-3" style="margin-bottom: 10px;">
										<input name="purchse_date" value="<?php echo (isset($purchse_date) && $purchse_date!='')?$purchse_date:date('Y-m-d') ?>" id="datepicker2" class="form-control" placeholder="YYYY-MM-DD" style="width:100% !important;">
									</div>
									<div class="col-sm-3 col-lg-3" style="margin-bottom: 10px;">
										<button name="search_purchase_date" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-search"></i> Searcch</button>
									</div>
								
							</div>
						</form>
					</div>


                    <div class=" col-sm-12">
                        <form class="form-horizontal" action="<?php echo base_url('inventory/stockEntryAction'); ?>" method="post">
                            <div class="row">
                            <div class="col-sm-3 col-lg-3" style="margin-bottom: 10px;">
                                <label>Entry Date</label>
                                <input name="entry_date" value="<?php echo (isset($purchse_date) && $purchse_date!='')?$purchse_date:date('Y-m-d') ?>" id="datepicker" class="form-control" placeholder="YYYY-MM-DD" style="width:100% !important;">
                            </div>
                            <div class=" col-xs-7">
                                <label>Note</label>
                                <textarea name="note" placeholder="Enter Stock Note" class="form-control"  rows="1"  style="width:100% !important;"></textarea>
                            </div>
                            <div class="col-xs-2" style="margin-top:22px; ">
                                <button type="submit" name="saveBtn" class="btn btn-success pull-right"><i class="glyphicon glyphicon-ok"></i> Save Stock</button>
                            </div>
							<div class="clearfix"></div>
							 <div class="col-sm-offset-5 col-sm-6" style="padding:10px;">
                               <?php 
			
							   if(!empty($purchase_date)){
								   echo "<b>Your searching purchase Date is "	.$purchase_date."</b>";
							   }
							   ?>
                            </div>
							
							

                            <table style="width:100%" rules="all" id="tableInfo" class="table table-bordered table-hover table-striped">
							<thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Product</th>
                                    <th>Previous Qty</th>
                                    <th>Today Purchase Qty</th>
                                    <th>Current Qty</th>
                                    <th>Today Use Qty</th>
                                    <th>Wasted Qty</th>
                                    <th>Today Final Stock Qty</th>
                                    <th>Prouct Unit</th>

                                </tr>
								</thead>
								<tbody id="tableDynamic">
								    
                                <?php
                                $i=1;
								if(!empty($products)){
								
                                foreach ($products as $products_row){
                                    if(($products_row->previous_product_qty +$products_row->today_purchase_product) >0){
								
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $products_row->productName."[".$products_row->productCode."]"; ?>
                                        <input type="hidden" name="product_id[]" value="<?php echo $products_row->productID ?>">
                                    </td>
                                    <td>
                                        <input type="text" name="previous_qty[]" id="previous_qty_<?php echo $i; ?>"  value="<?php echo $previous_qty=$products_row->previous_product_qty; ?>" class="form-control previous_qty input_style only-number">
                                    </td>
                                    <td>
                                        <input type="text"  name="today_purchase_qty[]" id="today_purchase_qty_<?php echo $i; ?>"  value="<?php echo $today_purchase=$products_row->today_purchase_product; ?>" class="form-control today_purchase_qty input_style only-number">
                                    </td>
                                    <td>
                                        <input type="text" readonly name="today_final_stock_qty[]" id="today_final_stock_qty_<?php echo $i; ?>"  value="<?php echo $today_stock=$previous_qty+$today_purchase; ?>" class="form-control today_final_stock_qty input_style only-number">
                                    </td>

                                    <td>
                                        <input type="text" name="today_use_qty[]" id="today_use_qty_<?php echo $i; ?>" value="<?php echo $today_use_qty=0;?>" class="form-control today_use_qty input_style only-number">
                                    </td>

                                    <td>
                                        <input type="text" name="wasted_qty[]" id="wasted_qty_<?php echo $i; ?>" value="0"  class="form-control wasted_qty input_style only-number">
                                    </td>

                                    <td>
                                        <input type="text" name="current_qty[]" id="current_qty_<?php echo $i; ?>" readonly value="<?php echo $final_stock=$today_stock-$today_use_qty; ?>" class="form-control current_qty input_style only-number">
                                    </td>

                                    <td style="width:100px;">
                                        <select name="unit[]"  id="unit_<?php echo $i; ?>" class="purchaseUnit form-control input_style_select"><option value=""> Unit</option><?php foreach($getProductUnit as $unit) {echo "<option value='$unit->id'>$unit->title</option>";} ?></select>
                                    </td>


                                </tr>
									<?php $i++; } }}else{ ?>
									<tr>
									<td colspan="9">No Product Found</td>
									</tr>
									<?php } ?>
									
								</tbody>
								<tfoot>
                                    <tr>
                                        <td colspan="10" style="text-align:left;"><a href="javascript:void(0);" id="addRow"
                                                           class="btn btn-info btn-sm"><i
                                                        class="glyphicon glyphicon-plus"></i> Add New</a></td>
                                    </tr>

                                    </tfoot>
                            </table>
                            <div class="row">
                                <div class="col-sm-offset-8 col-xs-4">
                                    <button type="submit" name="saveBtn" class="btn btn-success pull-right"><i class="glyphicon glyphicon-ok"></i> Save Stock</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<script>
    $(document).on("keyup", ".today_use_qty", function (event) {
        var today_use_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var previous_qty = parseFloat($("#previous_qty_" + element_id).val());
        var today_purchase_qty = parseFloat($("#today_purchase_qty_" + element_id).val());
        var wasted_qty = parseFloat($("#wasted_qty_" + element_id).val());
        var final_stock=previous_qty+today_purchase_qty
        if(!isNaN(final_stock)) {
            $("#current_qty_" + element_id).val(final_stock - (today_use_qty+wasted_qty));
        }
    });
    $(document).on("keyup", ".previous_qty", function (event) {
        var previous_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var today_use_qty = parseFloat($("#today_use_qty_" + element_id).val());
        var today_purchase_qty = parseFloat($("#today_purchase_qty_" + element_id).val());
        var final_stock=previous_qty+today_purchase_qty
        if(!isNaN(final_stock)) {
            $("#today_final_stock_qty_" + element_id).val(final_stock);
            $("#current_qty_" + element_id).val(final_stock-today_use_qty);
        }
    });
    $(document).on("keyup", ".today_purchase_qty", function (event) {
        var today_purchase_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var today_use_qty = parseFloat($("#today_use_qty_" + element_id).val());
        var previous_qty = parseFloat($("#previous_qty_" + element_id).val());
        var final_stock=previous_qty+today_purchase_qty
        if(!isNaN(final_stock)) {
            $("#today_final_stock_qty_" + element_id).val(final_stock);
            $("#current_qty_" + element_id).val(final_stock-today_use_qty);
        }
    });


    $(document).on("keyup", ".wasted_qty", function (event) {
        var today_wasted_qty = parseFloat($(this).val());
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var today_final_stock_qty = parseFloat($("#today_final_stock_qty_" + element_id).val());
        var today_use_qty = parseFloat($("#today_use_qty_" + element_id).val());
        var final_stock=today_final_stock_qty-(today_use_qty+today_wasted_qty);
        if(!isNaN(final_stock)) {
            $("#current_qty_" + element_id).val(final_stock);
        }
    });
    
     // for edit product information
    var total_present_product=parseFloat($("#total_count_product").val())+1;
    var scntDiv = $('#tableDynamic');
    var i = <?php echo $i; ?>;
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
                <select   name="unit[]"  required id="unit_' + i + '" class="purchaseUnit form-control input_style_select"><option value="">Unit</option><?php foreach($getProductUnit as $unit) {?> <option value="<?php echo $unit->id ?>"> <?php echo $unit->title ?></option> <?php } ?></select>\n\
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
                        console.log(ui.item.id);
                    
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
