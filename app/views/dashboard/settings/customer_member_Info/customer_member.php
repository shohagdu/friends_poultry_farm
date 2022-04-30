<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                                id="show_message"></span></div></div>
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?> Information</h3>

                    <button class="btn btn-primary pull-right" data-toggle="modal" onclick="addCustomerMemberInfo()"
                            data-target="#myModal"><i
                            class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-sm-4">
                                <label>Customer Name</label>
                                <div class="clearfix"></div>
                                <input type="text" id="customerName" class="form-control" placeholder="Enter Customer Name">
                                <input type="hidden" id="typeInfo" value="<?php  echo (!empty($type)?$type:'') ?>"
                                       class="form-control" placeholder="Enter Customer
                                Name">
                            </div>
                        </div>
                    </div>
                    <table id="customerMemberInfo" class='display dataTable table table-bordered table-hover' >
                        <thead>
                        <tr>
                            <th style="width:5%;">SL.</th>
                            <th>Name</th>
                            <th>Outlet</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Remarks</th>
                            <th>Current Due Amount</th>
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
    <div class="modal-dialog modal-lg">

        <form action="" method="post" id="customerMemberInfoForm" class="form-horizontal" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo (!empty($title)?$title:'') ?> Information</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required name="name" placeholder=" Name" id="name">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                             Mobile
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="mobile" placeholder=" Mobile" id="mobile">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Email
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="email" placeholder="Member Email" id="email">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                           Address
                        </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="address" placeholder="Address"
                                      id="address"></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Date of Birth
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker"
                                   name="customer_date_of_birth" value="<?php echo date('d-m-Y') ?>"
                                   placeholder="Date of
                                       Births"
                                   id="customer_date_of_birth">
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
                             Opening Balance Type
                        </label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input openingBalanceType" type="radio" name="openingBalanceType"
                                       id="openingBalanceType1"
                                       value="1" checked>
                                <label class="form-check-label" for="openingBalanceType1">
                                    Due (আপনি কাস্টমারের কাছে পাবেন)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input openingBalanceType" type="radio" name="openingBalanceType"
                                       id="openingBalanceType2" value="2">
                                <label class="form-check-label" for="openingBalanceType2">
                                    Advanced (কাস্টমার আপনার কাছে পাবেন)
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                             Opening <span class="openingBalanceType">Due</span> Amount
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control " name="openingDue" placeholder=" Amount"
                                   id="openingDue">
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
                            <input type="hidden" value="<?php  echo (!empty($redierct_page)?$redierct_page:'') ?>" name="redierct_page" id="redierct_page" >
                            <input type="hidden" value="<?php  echo (!empty($type)?$type:'') ?>" name="type" id="type" >
                            <button type="button" onclick="saveCustomerMemberInfo()" name="saveBtn" id="saveBtn"
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
