<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                                id="show_message"></span></div></div>
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?> </h3>
                    <button class="btn btn-info  pull-right" data-toggle="modal" onclick="addProductInfo()"
                            data-target="#productModal"><i class="glyphicon glyphicon-plus"></i> Add</button>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-2">
                                <label>Band</label>
                                <div class="clearfix"></div>
                                <select id="bandID" class="form-control" required style="width: 100%;">
                                    <option value="">Select Band</option>
                                    <?php if(!empty($bandInfo)){ foreach ($bandInfo as $band) { ?>
                                        <option value="<?php echo $band->id; ?>"><?php echo
                                            $band->title; ?></option>
                                    <?php } }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Source</label>
                                <div class="clearfix"></div>
                                <select id="sourceID" class="form-control" required style="width: 100%;">
                                    <option value="">Select Source</option>
                                    <?php if(!empty($sourceInfo)){ foreach ($sourceInfo as $source) { ?>
                                        <option value="<?php echo $source->id; ?>"><?php echo
                                            $source->title; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Type</label>
                                <div class="clearfix"></div>
                                <select id="typeID" class="form-control" required style="width: 100%;">
                                    <option value="">Select Type</option>
                                    <?php if(!empty($typeInfo)){ foreach ($typeInfo as $type) { ?>
                                        <option value="<?php echo $type->id; ?>"><?php echo $type->title; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Product Name</label>
                                <div class="clearfix"></div>
                                <input type="text" id="productName" class="form-control" placeholder="Enter Product Name">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id='ProductInfo' class='display dataTable table table-bordered table-hover' >
                            <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Name</th>
                                    <th>Product Code</th>
                                    <th>Brand</th>
                                    <th>Source</th>
                                    <th>Type</th>
                                    <th>Unit</th>
                                    <th>Sale Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="productModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Products  Details</h4>
            </div>
            <form action="<?php echo base_url('products/store'); ?>"  id="productInfoForm" class="form-horizontal"
                  enctype="multipart/form-data"
                  method="post">
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <label class="col-sm-3 text-right">Product Code</label>
                        <div class=" col-sm-9 ">
                            <input required="" id="productCode" type="text" name="productCode"
                                   placeholder="Product Code" class="form-control">
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <label class="col-sm-3 text-right"> Name</label>
                        <div class=" col-sm-9 ">
                            <input id="productNameShow" name="productName" class="form-control" placeholder="Product Name">
                        </div>
                    </div>

                     <div class="form-group">
                         <label class="col-sm-3 text-right"> Brand</label>
                         <div class=" col-sm-3 ">
                            <select name="productBrand" id="productBrand" class="form-control" required style="width: 100%;">
                                <option value="">Select Band</option>
                                <?php if(!empty($bandInfo)){ foreach ($bandInfo as $band) { ?>
                                    <option value="<?php echo $band->id; ?>"><?php echo
                                        $band->title; ?></option>
                                <?php } }?>
                            </select>
                         </div>
                         <label class="col-sm-2 text-right"> Source</label>
                         <div class=" col-sm-4">
                             <select name="productSource" id="productSource" class="form-control" >
                                 <option value="">Select Source</option>
                                 <?php if(!empty($sourceInfo)){ foreach ($sourceInfo as $source) { ?>
                                     <option value="<?php echo $source->id; ?>"><?php echo
                                         $source->title; ?></option>
                                 <?php } } ?>

                             </select>
                         </div>
                    </div>

                     <div class="form-group">
                         <label class="col-sm-3 text-right"> Type</label>
                         <div class=" col-sm-3 ">
                            <select name="productType" id="productType" class="form-control" required >
                                <option value="">Select Type</option>
                                <?php if(!empty($typeInfo)){ foreach ($typeInfo as $type) { ?>
                                    <option value="<?php echo $type->id; ?>"><?php echo $type->title; ?></option>
                                <?php } } ?>

                            </select>
                         </div>
                         <label class="col-sm-2 text-right">Unit</label>
                         <div class=" col-sm-4 ">
                             <select name="productUnit" id="productUnit" class="form-control" required >
                                 <option value="">Select Unit</option>
                                 <?php if(!empty($unitInfo)){ foreach ($unitInfo as $unit) { ?>
                                     <option value="<?php echo $unit->id; ?>"><?php echo $unit->title; ?></option>
                                 <?php } } ?>

                             </select>
                         </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="col-sm-3 text-right"> Purchase Price</label>
                        <div class=" col-sm-9 ">
                            <input id="productPurchasePrice" name="productPurchasePrice" class="form-control purchaseQtyPrice only-number"
                                   placeholder="Product Purchase Price">
                        </div>
                    </div>
                     <div class="form-group has-feedback">
                        <label class="col-sm-3 text-right"> Sales Price</label>
                        <div class=" col-sm-9 ">
                            <input id="productPrice" name="productPrice" class="form-control only-number"
                                   placeholder="Product Sales Price">
                        </div>
                    </div>


                    <div class="form-group has-feedback">
                        <label class="col-sm-3 text-right">Status</label>
                        <div class=" col-sm-3 ">
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                        <div class="col-sm-offset-2 col-sm-4 addInventoryCheckDiv ">
                            <div style="background: lightblue;color:red;padding: 5px" class="text-center">
                                <input type="checkbox" class="form-check-input addItemInventory"  name="addItemInventory" value="1" id="addItemInventory">
                                <label class="form-check-label" for="addItemInventory"> Item Add in Inventory</label>
                            </div>
                        </div>


                    </div>
                    <div class="form-group has-feedback showAddInventory" >
                        <label class="col-sm-3 text-right" >Purchase No.</label>
                        <div class=" col-sm-3 ">
                            <input name="purchaseNo" id="purchaseNo" readonly type="text" placeholder="Enter Purchase No"  class="form-control">
                        </div>
                        <label class="col-sm-2 text-right">Date</label>
                        <div class=" col-sm-4 ">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input name="purchaseDate" value="<?php echo date('Y-m-d'); ?>" id="datepicker" class="form-control" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                    </div>
                    <div class="form-group has-feedback showAddInventory">
                        <label class="col-sm-3 text-right"> Quantity</label>
                        <div class=" col-sm-3 ">
                            <input id="purchaseQuantity" name="quantity" class="form-control purchaseQtyPrice clearInput only-number"
                                   placeholder="Purchase Quantity">
                        </div>
                        <label class="col-sm-2 text-right"> Total Purchase</label>
                        <div class=" col-sm-4 ">
                            <input id="totalPurchaseAmount" name="totalPurchaseAmount" class="form-control clearInput" readonly
                                   placeholder="0.00">
                        </div>

                    </div>
                    <div class="form-group showAddInventory">
                        <label class="col-sm-3 text-right">Note/Remarks</label>
                        <div class=" col-sm-9 ">
                            <textarea name="note" colspan="2" id="note"  placeholder="Enter Note/Remarks........."  class="form-control clearInput"></textarea>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12 text-left">
                        <div class="box-body" id="alert_error" style="display: none;"> <div class="callout
                        callout-info" ><span id="show_error_save"></span></div></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-sm-12">
                        <input type="hidden" name="upId" id="upId" >
                        <button type="button" onclick="saveProductInfo()" name="saveBtn" id="saveBtn" class="btn
                                btn-success submit_btn"><i class="glyphicon glyphicon-ok-sign"></i> <span id="show_label"></span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon
                        glyphicon-remove"></i> Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

