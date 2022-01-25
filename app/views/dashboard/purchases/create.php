
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span    id="show_message"></span></div></div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                    <?php } ?>
                    <a href="<?php echo site_url('purchases/index'); ?>" class="btn btn-primary  pull-right" title="View"><i class="glyphicon glyphicon-list"></i> view</a>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="purchaseInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Purchase No.</label>
                                    <input name="purchaseNo" readonly id="purchaseNo" type="text" placeholder="Enter Purchase No"  class="form-control">
                                </div>
                            </div>
                            
                            


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="purchaseDate" id="datepicker" class="form-control" placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" colspan="2" id="note" type="text" placeholder="Enter Note...."  class="form-control"></textarea>
                                </div>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>

                    

                        <div>
                            <table class="table-style-main" class="table table-striped" style="border:1px solid #d0d0d0;">
                                <thead>
                                <tr>
                                    <th colspan="4"> Products Information </th>
                                </tr>
                                    <tr>
                                        <th style="width: 3%;">Sl.</th>
                                        <th>Product Name</th>
                                        <th style="width: 15%;">Quantity</th>
                                        <th style="width: 15%;">Unit Price</th>
                                        <th style="width: 15%;">Total Price</th>

                                        <th style="width: 6%;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tableDynamic">
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <input type="text" id="productName_1" required data-type="productName" placeholder="Product Name" class="productName form-control">
                                            <input type="hidden" name="productID[]" id="productID_1" class="form-control">
                                        </td>
                                        <td><input type="text" required name="quantity[]" id="quantity_1" placeholder="Quantity" class="quantPurchase form-control only-number"></td>
                                        <td><input type="text" required name="unitPrice[]" id="unitPrice_1" placeholder="Unit Price" class="unitPrice form-control only-number"></td>
                                        <td><input type="text" required name="totalPrice[]" id="totalPrice_1" placeholder="Total Price" class="totalPrice form-control only-number"></td>



                                        <td><a href="javascript:void(0);" id="deleteRow_1"  class="deleteRow btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr >
                                        <td colspan="3"><a href="javascript:void(0);" id="addRowStockIn" class="btn btn-info btn-flat btn-sm"><i class="glyphicon glyphicon-plus"></i> Add Product</a></td>
                                        <th class="text-right">Total Amount</th>
                                        <td>
                                            <input type="text" required name="net_purchase_amount" id="net_purchase_amount" readonly placeholder="Net Purchase Amount" class=" form-control only-number">

                                        </td>
                                    </tr>
                                </tfoot>

                            </table>

                           
                        </div>

                    </div>
                    
                    <div class="box-footer text-right">
                        <div class="col-sm-6 text-left">
                            <div id="show_error_save"></div>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" name="update_id">
                            <button type="button" id="submit_btn"  class="btn btn-success btn-flat"  onclick="savePurchaseInfo()"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>

</section>



