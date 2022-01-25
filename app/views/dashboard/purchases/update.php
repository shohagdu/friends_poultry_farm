
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
                    <a href="<?php echo site_url('purchases/view_purchage_info/'.((!empty($info->id))?$info->id:'')) ; ?>" class="btn btn-info   pull-right"  title="View"><i class="glyphicon glyphicon-share-alt"></i> view</a>
                    <a href="<?php echo site_url('purchases/index'); ?>" class="btn btn-primary  pull-right"
                       title="list" style="margin-right:10px;" ><i class="glyphicon glyphicon-list"></i> List</a>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="purchaseInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Stock No.</label>
                                    <input name="purchaseNo" value="<?php echo ((!empty($info->purchase_id))
                                        ?$info->purchase_id:'') ?>" type="text"
                                           placeholder="Enter Stock  No" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="purchaseDate" value="<?php echo ((!empty($info->purchase_date))
                                            ?$info->purchase_date:'') ?>" id="datepicker" class="form-control"
                                               placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" colspan="2" id="note" type="text" placeholder="Enter Note...."  class="form-control"><?php echo ((!empty($info->note))?$info->note:'') ?></textarea>
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
                                        <th style="width: 10%;">Quantity</th>
                                        <th style="width:15%;">Unit Price</th>
                                        <th style="width:15%;">Total Price</th>
                            
                                        <th style="width: 10%;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tableDynamic">
                                    <?php
                                    $i=1;
                                    $total=0;
                                    if(!empty($details)){
                                        foreach ($details as $row){
                                            $total+=$row->total_price;
                                           $prodouct_value= $row->product_name . ' [' . $row->productCode . '] '
                                            .$row->bandTitle.'-'.$row->sourceTitle.'-'
                                            .$row->ProductTypeTitle
                                    ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <input type="text" id="productName_<?php echo $row->id; ?>" value="<?php echo $prodouct_value; ?>" required
                                                   data-type="productName" placeholder="Product Name" class="productName form-control">
                                            <input type="hidden" value="<?php echo $row->product_id; ?>" name="productID[]"
                                                   id="productID_<?php echo $row->id; ?>"
                                                   class="form-control">
                                            <input type="hidden" required name="stock_id[]" value="<?php echo   $row->id
                                            ?>"
                                                   id="stock_id_<?php echo $row->id; ?>" placeholder="Stock ID"
                                                   class="form-control">
                                        </td>
                                        <td><input type="text" required name="quantity[]" value="<?php echo $row->total_item ?>"
                                        id="quantity_<?php echo $row->id; ?>" placeholder="Quantity" class="quant form-control only-number"></td>
                                        <td><input type="text" required name="unitPrice[]" id="unitPrice_<?php echo $row->id; ?>" value="<?php echo $row->unit_price ?>" placeholder="Unit Price" class="unitPrice form-control only-number"></td>
                                        <td><input type="text" required name="totalPrice[]" id="totalPrice_<?php echo $row->id; ?>" value="<?php echo $row->total_price ?>" placeholder="Total Price" class="totalPrice form-control only-number"></td>
                                    
                                        <td>
                                            <a href="javascript:void(0);" title="Delete" id="deleteRow_<?php echo $row->id; ?>"  class="deleteRow btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a>

                                            <button type="button" title="Single Update" onclick="purchaseSingleUpdate('<?php echo $row->id; ?>')" id="singleUpdate_<?php echo $row->id; ?>"  class="singleUpdate btn btn-info  btn-sm"><i class="glyphicon glyphicon-pencil"></i> </button>

                                        </td>
                                    </tr>
                                      <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr >
                                        <td colspan="3"><a href="javascript:void(0);" id="addRowStockIn" class="btn btn-info btn-flat btn-sm"><i class="glyphicon glyphicon-plus"></i> Add Product</a></td>
                                        <th class="text-right">Total Amount</th>
                                        <td>
                                            <input type="text" required name="net_purchase_amount" id="net_purchase_amount" value="<?php echo number_format($total,2); ?>" readonly placeholder="Net Purchase Amount" class=" form-control only-number">

                                        </td>
                                    </tr>
                                </tfoot>

                            </table>

                           
                        </div>

                    </div>
                    <div class="box-footer text-right">
                        <input type="hidden" name="update_id" value="<?php echo ((!empty($info->id))?$info->id:'') ?>">
                        <button type="button" id="submit_btn"  class="btn btn-success btn-flat"  onclick="savePurchaseInfo()"><i class="glyphicon glyphicon-ok-sign"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="purchaseProductModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-8">
                    <h4 class="modal-title" id="exampleModalLabel">Update Purchase Information</h4>
                </div>
                <div class="col-sm-4">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form method="POST" id="updateSinglePurchaseItemForm" role="form">
                    <div class="form-group">
                        <label for="productInfo">Product Information</label>
                        <input type="text" name="productInfo" class="form-control" readonly id="productInfo"  placeholder="Product Information">
                        <input type="hidden" name="productID" id="productID">
                        <input type="hidden" name="purchaseID" id="purchaseID">
                    </div>
                    <div class="form-group">
                        <label for="singleQty">Quantity</label>
                        <input type="text" name="singleQty" class="form-control purchase_single_item_change" id="singleQty" placeholder="Quantity">
                    </div>
                    <div class="form-group">
                        <label for="singleUnitPrice">Unit Price</label>
                        <input type="text" name="singleUnitPrice" class="form-control purchase_single_item_change" id="singleUnitPrice" placeholder="Quantity">
                    </div>
                    <div class="form-group">
                        <label for="singleTotalPrice">Total Price</label>
                        <input type="text" name="singleTotalPrice" readonly class="form-control" id="singleTotalPrice" placeholder="Total Price">
                    </div>
                    <div class="form-group">
                        <div id="show_error_save_info" style="color: red"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="singleUpdateBtn" onclick="updateSinglePurchaseItem()" class="btn btn-primary"><i class="glyphicon glyphicon-ok-circle"></i> Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Close</button>
            </div>
        </div>
    </div>
</div>



