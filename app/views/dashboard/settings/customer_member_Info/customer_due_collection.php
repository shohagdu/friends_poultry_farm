<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <a class="btn btn-warning pull-right" style="margin-left: 5px" href="<?php echo base_url('settings/customer_due_collection')
                    ?>"><i
                                class="glyphicon glyphicon-refresh"></i> Refresh
                    </a>
                    <button class="btn btn-primary pull-right" data-toggle="modal" onclick="addCustomerDueCollection()"
                            data-target="#myModal"><i
                            class="glyphicon glyphicon-plus"></i> Add New
                    </button>


                </div>
                <form action="" method="post">

                    <div class="form-group">
                        <div class="col-sm-3">
                            <label>Customer</label>
                            <div class="clearfix"></div>
                            <select id="searchCustomerId" class="customerNameDD" ></select>
                        </div>
                        <div class="col-sm-3">
                            <label>Transaction Type </label>
                            <div class="clearfix"></div>
                            <select  class="form-control" id="searchTransactionType">
                                <option value="">Select Transaction Type</option>
                                <option value="3">Collection from Customer (কাস্টমার থেকে টাকা গ্রহণ) </option>
                                <option value="11">Deposit to Customer (কাস্টমারকে টাকা প্রদান) </option>
                                <option value="12">Closing Discount (কাস্টমারকে ছাড় দেওয়া) </option>
                            </select>
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
                            <th>Trans. Code </th>
                            <th>Customer Name </th>
                            <th>Trans. Type </th>
                            <th>Date</th>
                            <th> Amount</th>
                            <th>Remarks</th>
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
    <div class="modal-dialog modal-lg">
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
                            Transaction Type
                        </label>
                        <div class="col-sm-9">
                            <select name="transactionType" class="form-control" id="transactionType">
                                <option value="">Select Transaction Type</option>
                                <option value="3">Collection from Customer (কাস্টমার থেকে টাকা গ্রহণ) </option>
                                <option value="11">Deposit to Customer (কাস্টমারকে টাকা প্রদান) </option>
                                <option value="12">Closing Discount (কাস্টমারকে ছাড় দেওয়া) </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Customer Name
                        </label>
                        <div class="col-sm-9">
                            <select id="customerIdDD" class="customerNameDD" name="customer_id"
                                    required="required"></select>

                        </div>
                    </div>

                    <div class="form-group col-sm-12 totalDueAmountDiv">
                        <label class="col-sm-3 text-right">
                           Total Due Amount
                        </label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control"
                                   name="due_amount"
                                   placeholder="0.00"
                                   id="due_amount">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 transTypeChange" style="display: none">
                        <label class="col-sm-3 text-right">
                            Account Name
                        </label>
                        <div class="col-sm-9">
                            <select name="accountID" id="accountID" class="form-control select2" style="width: 100%;">
                                <option value="">Select Account</option>
                                <?php if(!empty($accounts)){ foreach ($accounts as $account) { ?>
                                    <option value="<?php echo $account->accountID; ?>"><?php echo $account->accountName; ?></option>
                                <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 paymentType" style="display: none">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th rowspan="4"  class="paymentBy text-right"> Received By </th>
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
                                               class="form-control payment_ctg_amount ">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="cash_cheque"
                                                                            onchange="isCheckedById(this)" class="receivedByChecked"
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
                                               class="form-control payment_ctg_amount amountClear">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="due_cheque" class="receivedByChecked"
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
                                               class="form-control payment_ctg_amount amountClear">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="radio-inline"> <input type="checkbox" id="online" class="receivedByChecked"
                                                                            onclick="isCheckedById(this)"
                                                                            value="online"
                                                                            name="payment_by[3]"
                                            ></label>
                                    </td>
                                    <td>
                                        Online Payment
                                    </td>

                                    <td>
                                        <input placeholder="0.00"  type="text"  id="online_amount" readonly
                                               name="payment_ctg_amount[]"
                                               class="form-control payment_ctg_amount amountClear">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="form-group col-sm-12" >
                        <label class="col-sm-3 text-right">
                            <span class="transAmount">Amount</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control"
                                   name="payment_now"
                                   placeholder="0"
                                   id="paidNow">
                        </div>
                    </div>
                    <div class="form-group col-sm-12 currentDueAmountDiv">
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

