<section class="content">
    <div class="row">
    <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                            id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <a href="<?php echo site_url('purchases/create'); ?>" class="btn btn-primary  pull-right" title="Add"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Purchase No</label>
                            <div class="clearfix"></div>
                            <input type="text" id="purchaseNoSearch" class="form-control" placeholder="Enter Purchase No">
                        </div>
                        <div class="col-sm-3">
                            <label>Product Code</label>
                            <div class="clearfix"></div>
                            <input type="text" id="productCode" class="form-control" placeholder="Enter Product Code">
                        </div>
                    </div>
                </form>     
                <div class="clearfix"></div>   
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id='purchaseInfo' class='display dataTable table table-bordered table-hover' >
                            <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Stock No</th>
                                    <th>Date</th>
                                    <th class="width30per">Product Codes</th>
                                    <th>Note</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>



                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
