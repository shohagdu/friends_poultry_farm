
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
                    <a href="<?php echo site_url('transfer/index'); ?>" class="btn btn-primary  pull-right"
                       title="View"><i class="glyphicon glyphicon-list"></i> view</a>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="transferInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Transfer No.</label>
                                    <input name="tranferNo" id="tranferNo" readonly type="text" placeholder="Transfer
                                     No"  class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="transDate" value="<?php echo date('Y-m-d'); ?>" id="datepicker"
                                               class="form-control"
                                               placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">

                                    <div class="form-group">
                                        <label>From Outlet<sup>*</sup></label>
                                         <!--
                                        <select name="from_outlet" id="from_outlet" class="form-control"
                                                style="width:100%;" >
                                            <option value="">Select Outlet </option>
                                            <?php if(!empty($outlet_info)){ foreach ($outlet_info as $outlet) { ?>
                                            <option value="<?php echo $outlet->id; ?>"><?php echo $outlet->name; ?></option>
                                            <?php } }?>
                                        </select>
                                        -->
                                        <input type="hidden" readonly value="<?php echo $this->outletID ?>"
                                               name="from_outlet" id="from_outlet"  class="form-control">
                                        <input type="text" readonly  value="<?php echo $this->outletData['name']; ?>"
                                               class="form-control">
                                     </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>To Outlet<sup>*</sup></label>
                                    <select name="to_outlet" id="to_outlet" class="form-control" style="width:100%;" >
                                        <option value="">Select Outlet</option>
                                        <?php if(!empty($outlet_info)){ foreach ($outlet_info as $outlet) { ?>
                                            <option value="<?php echo $outlet->id; ?>"><?php echo $outlet->name; ?></option>
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
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            <input type="text" id="productName_1" required data-type="productName" placeholder="Product Name" class="productName form-control">
                                            <input type="hidden" name="productID[]" id="productID_1" class="form-control">
                                        </td>
                                        <td><input type="text" required name="quantity[]" id="quantity_1" placeholder="Quantity" class="quant form-control only-number"></td>
                                    
                                        <td><a href="javascript:void(0);" id="deleteRow_1"  class="deleteRow btn btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
                                    </tr>

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
                                              class="form-control"></textarea>
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
                                <input type="hidden" name="update_id">
                                <button type="button" id="submit_btn"  class="btn btn-success btn-flat"
                                        onclick="saveTransferInfo()"><i class="glyphicon glyphicon-ok-sign"></i> Save
                                    Transfer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>  
    </div>

</section>



