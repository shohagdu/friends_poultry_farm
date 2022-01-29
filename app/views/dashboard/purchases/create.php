<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body" id="alert" style="display: none;">
                <div class="callout callout-info"><span id="show_message"></span></div>
            </div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo(!empty($title) ? $title : '') ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                    <?php } ?>
                    <a href="<?php echo site_url('purchases/index'); ?>" class="btn btn-primary  pull-right"
                       title="View"><i class="glyphicon glyphicon-list"></i> view</a>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="purchaseInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class=" col-md-4">
                                <div class="form-group">
                                    <label>Supplier Name</label>
                                    <input type="text" autofocus style="border: 1px solid #6666ff" placeholder="Enter Supplier Name / Mobile No."
                                           name="supplierName"
                                           id="supplierNameSearch"
                                           class="form-control">
                                    <input type="hidden" name="supplierNameSearchId" id="supplierNameSearchId"
                                           class="form-control">


                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-md-3">
                                <div class="form-group">
                                    <label>Purchase No.</label>
                                    <input name="purchaseNo" tabindex="-1" readonly id="purchaseNo" type="text"
                                           placeholder="Enter
                                     Purchase No" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date<sup>*</sup></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input tabindex="-1" name="purchaseDate" id="datepicker" class="form-control"
                                               readonly
                                               value="<?php echo date('Y-m-d') ?>"
                                               placeholder="YYYY-MM-DD">
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="clearfix"></div>

                        <div class="form-group">
                            <input type="text" style="border: 1px solid #6666ff" placeholder="Search Product Name / Code" name="purchaseProduct" id="purchaseProductSearch" class="form-control">
                        </div>


                        <div>
                            <table class="table-style-main" class="table table-striped"
                                   style="border:1px solid #d0d0d0;">
                                <thead>
                                <tr>
                                    <th style="width: 3%;">Sl.</th>
                                    <th>Product Name</th>
                                    <th style="width: 15%;">Quantity</th>
                                    <th style="width: 15%;">Unit Price</th>
                                    <th style="width: 15%;">Total Price</th>

                                    <th style="width: 6%;">#</th>
                                </tr>
                                </thead>
                                <tbody id="tableDynamicPurchase">

                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3"></td>
                                    <th class="text-right">Total Amount</th>
                                    <td>
                                        <input type="text" required name="net_purchase_amount" id="net_purchase_amount"
                                               readonly placeholder="Net Purchase Amount"
                                               class=" form-control only-number">

                                    </td>
                                </tr>
                                </tfoot>

                            </table>


                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea name="note" colspan="2" id="note" type="text" placeholder="Enter Note...."
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="box-footer text-right">
                        <div class="col-sm-8 text-left">
                            <div id="show_error_save"></div>
                        </div>
                        <div class="col-sm-4">
                            <input type="hidden" name="update_id">
                            <button type="button" id="submit_btn" class="btn btn-success btn-lg btn-block"
                                    onclick="savePurchaseInfo()"><i class="glyphicon glyphicon-ok-sign"></i> Save
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

</section>



