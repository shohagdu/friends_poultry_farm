<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                            id="show_message"></span></div></div>
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?> Information</h3>

                    <button class="btn btn-primary pull-right" data-toggle="modal" onclick="addShipmentSetup()"
                            data-target="#myModal"><i
                            class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
                <div class="box-body">
                    <table id="shipmentSetupTable" class='display dataTable table table-bordered table-hover' >
                        <thead>
                        <tr>
                            <th style="width:5%;">SL.</th>
                            <th>Title</th>
                            <th>Arrival DT</th>
                            <th>Receive DT</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th style="width:15%;">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
</section>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <form action="" method="post" id="shipmentSetupInfoForm" class="form-horizontal" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo (!empty($title)?$title:'') ?> Information</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Shipment Title
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required name="title" placeholder=" Shipment Title" id="title">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Arrival Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker"
                                   name="arrival_date" value="<?php echo date('d-m-Y') ?>"
                                   placeholder="Arrival Date"
                                   id="arrival_date">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Receive Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker"
                                   name="receive_date" value="<?php echo date('d-m-Y') ?>"
                                   placeholder="Receive Date"
                                   id="receive_date">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Remarks
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="remarks" placeholder="Remarks"
                                      id="remarks"></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Status
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>

                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="col-sm-12 text-left">
                        <div class="box-body" id="alert_error" style="display: none;"> <div class="callout
                        callout-danger"><span id="show_error_save"></span></div></div>
                    </div>
                    <div class="col-sm-12">
                        <input type="hidden" name="upId" id="upId" >
                        <button type="button" onclick="saveShipmentSetupInfo()" name="saveBtn" id="saveBtn"
                                class="btn
                                btn-success submit_btn"><i class="glyphicon glyphicon-ok-sign"></i> <span id="show_label"></span></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon
                        glyphicon-remove"></i> Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
