<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>

                    <button class="btn btn-primary pull-right" data-toggle="modal" onclick="addCustomerDueCollection()"
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
                    <table id='customerDueCollectionInfo' class='display dataTable table table-bordered
                    table-hover' >
                        <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Member Name </th>
                            <th>Date</th>
                            <th>Collection Amt</th>
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
        <form action="" method="post" id="customerDueCollectionForm" class="form-horizontal"
              enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo (!empty($title)?$title:'') ?> Information</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Customer Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" id="customerName_11" class="customerName form-control"
                                   placeholder="Enter Customer Name / Mobile / Address"  >

                            <input type="hidden" name="customer_id" id="customerID_11" class="  form-control"  >
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Due Amount
                        </label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control"
                                   name="due_amount"
                                   placeholder="0.00"
                                   id="due_amount">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="4"  class="paymentBy text-right"> Payment By </th>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="cash"
                                                                            value="cash"
                                                                            onchange="isCheckedById(this)"
                                                                            checked
                                                                            name="payment_by[0]"
                                            ></label>
                                    </td>
                                    <td>
                                        Cash
                                    </td>

                                    <td>
                                        <input type="text" placeholder="0.00"   id="cash_amount"
                                               name="payment_ctg_amount[]"
                                               class="form-control payment_ctg_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="cash_cheque"
                                                                            onchange="isCheckedById(this)"
                                                                            value="cash_cheque"
                                                                            name="payment_by[1]"
                                            ></label>
                                    </td>
                                    <td>
                                        Cash cheque
                                    </td>

                                    <td>
                                        <input type="text" placeholder="0.00"  readonly
                                               id="cash_cheque_amount"
                                               name="payment_ctg_amount[]"
                                               class="form-control payment_ctg_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="due_cheque"
                                                                            onclick="isCheckedById(this)"
                                                                            value="due_cheque"
                                                                            name="payment_by[2]"
                                            ></label>
                                    </td>
                                    <td>
                                        Due cheque
                                    </td>

                                    <td>
                                        <input type="text" placeholder="0.00"   id="due_cheque_amount"
                                               name="payment_ctg_amount[]" readonly
                                               class="form-control payment_ctg_amount">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="online"
                                                                            onclick="isCheckedById(this)"
                                                                            value="online_payment"
                                                                            name="payment_by[3]"
                                            ></label>
                                    </td>
                                    <td>
                                        Online Payment
                                    </td>

                                    <td>
                                        <input placeholder="0.00"  type="text"  id="online_amount" readonly
                                               name="payment_ctg_amount[]"
                                               class="form-control payment_ctg_amount">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Payment Now
                        </label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control"
                                   name="payment_now"
                                   placeholder="0"
                                   id="paidNow">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Current Due
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control"
                                   name="current_due_amount"
                                   placeholder="0.00" readonly
                                   id="current_due_amount">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Payment Date
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker"
                                   name="payment_date" value="<?php echo date('d-m-Y') ?>"
                                   placeholder="Payment Date"
                                   id="payment_date">
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
                        <button type="button" onclick="saveCustomerDueCollection()" name="saveBtn" id="saveBtn"
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

