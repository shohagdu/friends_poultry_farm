<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <a href="<?php echo site_url('shipment_info/create_stock_info'); ?>" class="btn btn-primary
                    pull-right" title="Add"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <form action="" method="post">

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Shipment </label>
                            <div class="clearfix"></div>
                            <select id="shipmentID" class="form-control select2" required style="width: 100%;">
                                <option value="">Select Shipment </option>
                                <?php if(!empty($shipment_info)){ foreach ($shipment_info as $shipment) { ?>
                                    <option value="<?php echo $shipment->id; ?>"><?php echo $shipment->title;
                                    ?></option>
                                <?php } }?>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id='shipmnetStockInfo' class='display dataTable table table-bordered table-hover' >
                        <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Shipment Name </th>
                            <th>Date</th>
                            <th>Total Bill</th>
                            <th>Total cantt Qty</th>
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
</section>
