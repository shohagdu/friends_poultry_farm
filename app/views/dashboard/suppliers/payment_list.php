

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Suppliers</h3>
                    <h3 class="pull-right box-title">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Payment</button>

                    </h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width:5%;">SL.</th>
                                <th style="width:20%"> Name </th>
                                <th style="width:20%">Total Due</th>
                                <th style="width:20%">Total Payment</th>
                                <th> Status</th>
                                <th style="width:20%">Present Balance</th>
                                <th style="width:20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($suppliers_all_dues as $key => $supplier) {
                                $payment = $this->SUPPLIERS->allpayment_by_id($supplier['supplierID']);
                                $supplier_due_amount = $supplier['total_due'] - $payment;
                                ?>
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $supplier['supplierName']; ?></td>
                                    <td><?php echo $supplier['total_due']; ?></td>
                                    <td><?php echo $payment; ?></td>
                                    <td>
                                        <?php
                                        if ($supplier_due_amount < 0) {
                                            echo '<span style="color:green;">Advanced</span>';
                                        } else if ($supplier_due_amount == 0) {
                                            
                                            echo '<span style="color:blue;"> Balance</span>';
                                        } else {
                                            echo '<span style="color:red;">Due </span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo abs($supplier_due_amount); ?></td>
                                    <td><a href="<?php echo site_url('Suppliers/supplier_payment_summary/'.$supplier['supplierID']); ?>" class="btn btn-primary btn-xs ">Payment Report</a></td>
                                </tr>

                            <?php } ?>
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



    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Supplier Payment</h4>
                </div>
                <div class="modal-body mycssClass">
                    <form action="<?php echo site_url('Suppliers/insert_payment'); ?>" method="post">
                        <?php
                        $supplier = $this->db->get('tbl_pos_suppliers')->result_array();
                        ?>
                        <div class="form-group has-feedback">
                            <label>Supplier</label>
                            <select name="supplier" onchange="get_supplier_id(this.value)" id="supplierID" class="form-control select2 supplier_id" style="width: 100%;">
                                <option value="">(:- Supplier -:)</option>
                                <?php foreach ($supplier as $each_supplier) { ?>
                                    <option value="<?php echo $each_supplier['supplierID']; ?>"><?php echo $each_supplier['supplierName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Due Amount</label>
                            <input id="due_amount" readonly class="form-control" type="text" value="" name="due_amount" placeholder="Due Amount"/>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Payment Type</label>
                            <select name="account_id" class="form-control select2 bank_id" style="width: 100%;">
                                <option value="">(:- Account -:)</option>
                                <?php foreach ($account as $productcatagory) { ?>
                                    <option value="<?php echo $productcatagory->accountID; ?>"><?php echo $productcatagory->accountName; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group has-feedback">
                            <label> Available Amount</label>
                            <input id="cash_amount"  readonly class="form-control av_amount" placeholder="Pay Amount">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Pay Amount</label>
                            <input name="payamount" readonly id="mySelect2" onkeyup="check_payment_validation()" onchange="myFunction()" class="form-control" placeholder="Pay Amount" required>
                        </div>
                        <div id="advanched" class="form-group has-feedback" style="display: none;">
                            <label style="color:red;">Advanced !!</label>
                            <input  readonly id="advanced_amount" name="advanced_amount" class="form-control" placeholder="Advanced" required>
                        </div>
                        <div id="remain_due" class="form-group has-feedback" style="display: none;">
                            <label style="color:green;">Remaining Due</label>
                            <input  readonly id="remain_due_amount" name="remain_due_amount"  class="form-control" placeholder="Due" required>
                        </div>
                        <div id="paymentDate" class="form-group has-feedback" >
                            <label>Payment Date</label>
                            <input   id="datepicker" name="paymentDate"  class="form-control" value="<?php echo date('Y-m-d');?>">
                        </div>

                        <div class="form-group has-feedback">
                            <label>Note </label>
                            <textarea name="note" rows="1"  class="form-control" placeholder="Comment...." ></textarea>
                        </div>

                        <div class="form-group has-feedback">
                            <button type="submit" name="submitBtn" disabled id="btnSubmit" class="btn btn-success"><i class="fa fa-save"></i> &nbsp; Submit</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-remove"></i>&nbsp;&nbsp;Close</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
    <script>
        function check_payment_validation() {
            var dueAmount = $("#due_amount").val();
            var cashAmount = $("#cash_amount").val();
            var paymentAmount = $("#mySelect2").val();

            if (parseInt(cashAmount) < parseInt(paymentAmount)) {
                alert('Sorry ! Amount can not be greater than bank Amount.');
                $("#mySelect2").val('');
                $("#mySelect2").css("background-color", "yellow");
                $("#btnSubmit").prop("disabled", true);
            } else {
                if (parseInt(dueAmount) < parseInt(paymentAmount)) {
                    var advan = parseInt(paymentAmount) - parseInt(dueAmount);
                    $("#advanced_amount").val(advan);
                    $("#remain_due_amount").val('');
                    $("#remain_due").hide();
                    $("#advanched").show();

                } else {

                    var dueremain = parseInt(dueAmount) - parseInt(paymentAmount);

                    $("#remain_due_amount").val(dueremain);
                    $("#advanced_amount").val('');
                    $("#advanched").hide();
                    $("#remain_due").show();
                }
                $("#mySelect2").css("background-color", "white");
                $("#btnSubmit").prop("disabled", false);
            }
        }


        $(function () {
            $(".bank_id").change(function () {

                var supplier_id = $("#supplierID").val();

                if (supplier_id == '') {
                    alert("Please At first select Supplier Name.");
                } else {
                    var bank_id = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>cashbook/getbankavailable/",
                        data: 'bank_id=' + bank_id,
                        dataType: 'json',
                        success: function (data) {
                            if (data.bavbalance == null) {
                                $("#mySelect2").prop("readonly", true);
                                $("#btnSubmit").prop("disabled", true);
                                $('.av_amount').val('');
                                $("#remain_due_amount").val('');
                                $("#advanced_amount").val('');
                                $("#mySelect2").val('');
                                $("#advanched").hide();
                                $("#remain_due").hide();
                            } else {
                                $("#mySelect2").prop("readonly", false);
                                $('.av_amount').val(data.bavbalance);
                            }
                        }
                    });
                }


            });
        });


        function get_supplier_id(supplier_id) {
            $.ajax({
                url: "<?php echo site_url('Suppliers/supplierPayment_balance'); ?>",
                data: {supplier_id: supplier_id},
                type: "POST",
                success: function (hr) {
                    $('.av_amount').val('');
                    $("#remain_due_amount").val('');
                    $("#advanced_amount").val('');
                    $("#mySelect2").val('');
                    $("#advanched").hide();
                    $("#remain_due").hide();
                    $("#cash_amount").val('');
                    $("#due_amount").val(hr);
                }
            });
        }
    </script>




</section>
<!-- /.content -->