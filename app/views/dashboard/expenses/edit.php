<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Expense</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                </div>
                <div class="box-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Account Head</label>
                            <select name="head_id" class="form-control head_id select2" style="width: 100%;">
                                <option value="">-- Select Account Head --</option>
                                <?php foreach ($expensehead as $expenseHead) { ?>
                                    <option <?php
                                    if (!empty($expense['head_id']) && $expense['head_id'] == $expenseHead->expheadID) {
                                        echo "selected";
                                    }
                                    ?> value="<?php echo $expenseHead->expheadID; ?>"><?php echo $expenseHead->title; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Account Sub Head</label>


                            <select name="sub_head_id" class="form-control subitem_1" style="width: 100%;">
                                <option value="">-- Select Sub Head --</option>
                                <?php
                                $edit_id = $expense['head_id'];
                                $data['id'] = $edit_id;
                                $data['sub_head'] = $this->COMMON_MODEL->get_data_list_by_single_column('tbl_pos_exp_sub_head', 'head_id', $edit_id);
                                $this->load->view('ajax_form_datas', $data);
                                ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Account</label>
                            <select name="account_id" class="form-control select2 bank_id" style="width: 100%;">

                                <?php foreach ($account as $eachaccount) { ?>
                                    <option <?php
                                    if ($eachaccount->accountID == $expense['account_id']) {
                                        echo "selected";
                                    }
                                    ?> value="<?= $eachaccount->accountID ?>"><?= $eachaccount->accountName ?></option>

                                <?php } ?>
                            </select>

                        </div>
                        <div class="form-group has-feedback">
                            <label>Remaining Amount</label>
                            <input readonly id="mySelect" onchange="myFunction()" class="form-control av_amount"
                                   placeholder="Remaining Amount">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Amount</label>
                            <input required="" id="mySelect2" onchange="myFunction()"
                                   value="<?php echo $expense['amount'] ?>" name="amount" class="form-control "
                                   placeholder="Amount">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Date</label>
                            <input required="" id="datepicker"
                                   value="<?php echo date('Y-m-d', strtotime($expense['created_at'])); ?>" name="date"
                                   class="form-control " placeholder="YYYY-MM-DD">
                        </div>

                        <div class="row">
                            <div class="col-xs-4">

                            </div>
                            <div class="col-xs-4">

                            </div>
                            <div class="col-xs-4">
                                <button type="submit" name="submitBtn" class="btn btn-primary btn-block btn-flat">Update</button>
                                <input type="hidden" id="lastinsid" name="lastinsid" value="<?php echo $this->uri->segment('3'); ?>">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</section>
<!-- /.content -->

<script type="text/javascript">
    var randomString = function (length) {
        var text = "";
        var possible = "0123456789";
        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    var codeLenghtCheck = function () {
        var code = $('#productCode').val();
        if (code.length < 8) {
            $("#productCodeError").text("Product Code must be minimum 8 digit lenght.");
        } else if (code.length > 8) {
            $("#productCodeError").text("Product Code must be maximum 8 digit lenght.");
        } else {
            $("#productCodeError").empty();
        }
    };

    $("#random").click(function () {
        $('#productCode').val(randomString(8));
        codeLenghtCheck();
    });

    $("#productCode").keyup(function () {
        codeLenghtCheck();
    });

    $("#productCode").change(function () {
        codeLenghtCheck();
    });

</script>

<script>

    $(function () {
        $(".bank_id").change(function () {
            var bank_id = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>cashbook/getbankavailable/",
                data: 'bank_id=' + bank_id,
                dataType: 'json',
                success: function (data) {
                    $('.av_amount').val(data.bavbalance);
                }
            });
        });
    });

    $(document).ready(function () {
        $('.head_id').change(function () {
            var head_id = $(this).val();

            $.ajax({
                url: "<?php echo site_url('expenses/ajaxSubheadload') ?>",
                method: "POST",
                data: {head_id: head_id},
                dataType: "text",
                success: function (data) {
                    $('.subitem_1').html(data);
                }
            })
        });


        var bank_id = $(".bank_id").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>cashbook/getbankavailable/",
            data: 'bank_id=' + bank_id,
            dataType: 'json',
            success: function (data) {
                $('.av_amount').val(data.bavbalance);
            }
        });

    });


</script>

<script>
    function myFunction() {
        var x = document.getElementById("mySelect").value;
        var y = document.getElementById("mySelect2").value;
        if (parseFloat(x) < parseFloat(y)) {
            alert('Expense Amount can not be geterthen bank amount');
            $("#mySelect2").val('');
        }

    }
</script>