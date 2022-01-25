
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
                    <a href="<?php echo site_url('transfer/view/'.((!empty($info->id))?$info->id:'')) ; ?>" class="btn btn-info   pull-right"  title="View"><i class="glyphicon glyphicon-share-alt"></i> view</a>
                    <a href="<?php echo site_url('transfer/index'); ?>" class="btn btn-primary  pull-right"
                       title="list" style="margin-right:10px;" ><i class="glyphicon glyphicon-list"></i> List</a>

                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="transferInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Transfer No.</label>
                                    <input  readonly type="text" value="<?php echo (!empty($info->transfer_id)?$info->transfer_id:''); ?>"
                                            placeholder="Transfer No"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="transDate" value="<?php echo !empty($info->transfer_date)?date('Y-m-d',strtotime($info->transfer_date)):''; ?>" id="datepicker"
                                               class="form-control"
                                               placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label>From Outlet<sup>*</sup></label>
                                    <input type="text" readonly  value="<?php echo (!empty($info->from_outlet_name)?$info->from_outlet_name:''); ?>"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Outlet<sup>*</sup></label>
                                    <select name="to_outlet" id="to_outlet" class="form-control" style="width:100%;" >
                                        <option value="">Select Outlet</option>
                                        <?php if(!empty($outlet_info)){ foreach ($outlet_info as $outlet) {
                                            $selected=((!empty($info->to_outlet_id) && $info->to_outlet_id==$outlet->id)
                                                ?"selected":'')
                                            ?>
                                            <option value="<?php echo $outlet->id; ?>" <?php echo $selected; ?>><?php
                                                echo
                                            $outlet->name; ?></option>
                                        <?php } }?>
                                    </select>
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
                            
                                        <th style="width: 6%;">#</th>
                                    </tr>
                                </thead>
                                <tbody id="tableDynamic">
                                    <?php
                                    if(!empty($details)){
                                        $i=1;
                                        foreach ($details as $row){
                                           $prodouct_value= $row->product_name . ' [' . $row->productCode . '] '
                                            .$row->bandTitle.'-'.$row->sourceTitle.'-'
                                            .$row->ProductTypeTitle
                                    ?>

                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <input type="text" id="productName_1" value="<?php echo $prodouct_value; ?>" required
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
                                    
                                        <td><a href="javascript:void(0);" id="deleteRow_<?php echo $row->id; ?>"  class="deleteRow btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>
                                      <?php
                                        }
                                    }
                                    ?>

                                </tbody>
                                <tfoot>
                                    <tr >
                                        <td colspan="4"><a href="javascript:void(0);" id="addRowStockIn" class="btn btn-info btn-flat btn-sm"><i class="glyphicon glyphicon-plus"></i> Add Product</a></td>
                                    </tr>
                                </tfoot>

                            </table>

                           
                        </div>

                    </div>
                    <div class="box-footer text-right">
                        <div class="col-md-4 text-left">
                            <div class="row">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" rows="2" id="note" placeholder="Enter Note...."
                                              class="form-control"><?php echo (!empty($info->note)
                                            ?$info->note:''); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="col-sm-12 text-center">
                                <div id="show_error_save"></div>
                            </div>
                        </div>

                        <div class="col-md-3 text-right">
                            <div class="form-group">
                                <input type="hidden" name="update_id" value="<?php echo (!empty($info->id)?$info->id:''); ?>">
                                <button type="button" id="submit_btn"  class="btn btn-success btn-flat"
                                        onclick="saveTransferInfo()"><i class="glyphicon glyphicon-ok-sign"></i> Update
                                    Transfer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>

</section>



