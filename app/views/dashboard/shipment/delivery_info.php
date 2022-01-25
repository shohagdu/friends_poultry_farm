<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>

                    <button class="btn btn-primary pull-right" data-toggle="modal" onclick="addShipmentDelivery()"
                            data-target="#myModal"><i
                            class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
                <form action="" method="post">

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Member Name </label>
                            <div class="clearfix"></div>
                            <input type="text" id="member_name_1" class=" memberName form-control"
                                   placeholder="Enter Member Name / Mobile / Address"  >
                            <input type="hidden" id="memberid_1" class="  form-control"  >

                            </input>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id='shipmnetDeliveryInfo' class='display dataTable table table-bordered
                    table-hover' >
                        <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Member Name </th>
                            <th>Date</th>
                            <th>Delivery Qty</th>
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
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <form action="" method="post" id="shipmentDeliveryInfoForm" class="form-horizontal"
              enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo (!empty($title)?$title:'') ?> Information</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Member Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" id="member_name_11" class="memberName form-control"
                                   placeholder="Enter Member Name / Mobile / Address"  >
                            <input type="hidden" name="member_id" id="memberid_11" class="  form-control"   >
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                           Due Qty
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"
                                   name="due_qty"
                                   placeholder="0"
                                   id="due_qty">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                           Delivery Qty
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"
                                   name="delivery_qty"
                                   placeholder="0"
                                   id="delivery_qty">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Current Stock Qty
                        </label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control"
                                   name="current_stock_qty"
                                   placeholder="0"
                                   id="current_stock_qty">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Delivery Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker"
                                   name="delivery_date" value="<?php echo date('d-m-Y') ?>"
                                   placeholder="Delivery Date"
                                   id="delivery_date">
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
                        <button type="button" onclick="saveShipmentDeliveryInfo()" name="saveBtn" id="saveBtn"
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
