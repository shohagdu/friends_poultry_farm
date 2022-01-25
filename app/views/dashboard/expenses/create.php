
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">New Expense</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                    <a href="<?php echo site_url('expenses/index'); ?>"
                       class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> View</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-offset-1 col-sm-10">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Account Head</label>
                            <select required name="head_id" class="form-control head_id select2" style="width: 100%;" >
                                <option   value="">-- Select Account Head --</option>
                                <?php foreach ($expensehead as $expenseHead) { ?>
                                    <option value="<?php echo $expenseHead->expheadID; ?>"><?php echo $expenseHead->title; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Account Sub Head</label>
                            <select  required name="sub_head_id" class="form-control subitem_1 select2" style="width: 100%;" >
                                <option value="">-- Select Sub Head --</option>


                            </select>
                        </div>
                        <div class="form-group">
                            <label>Account</label>
                            <select required name="account_id" class="form-control select2 bank_id" style="width: 100%;">
                                <option value="">-- Select Account --</option>
                                <?php foreach ($account as $eachaccount) { ?>
                                    <option value="<?php echo $eachaccount->accountID; ?>"><?php echo $eachaccount->accountName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Remaining Amount</label>
                            <input readonly id="mySelect" onchange="myFunction()" class="form-control av_amount" placeholder="Remaining Amount">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Amount</label>
                            <input required="" id="mySelect2" onchange="myFunction()" name="amount" class="form-control " placeholder="Amount">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Date</label>
                            <input required="" value="<?php echo date('Y-m-d'); ?>" id="datepicker" name="date" class="form-control"  placeholder="YYYY-MM-DD">
                        </div>



                        <div class="row">
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary  btn-sm">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
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
                url: "ajaxSubheadload",
                method: "POST",
                data: {head_id: head_id},
                dataType: "text",
                success: function (data)
                {
                    $('.subitem_1').html(data);
                }
            })
        });
    });

</script>
<script>
    function myFunction() {
        var x = document.getElementById("mySelect").value;
        var y = document.getElementById("mySelect2").value;

        if ( parseInt(x) < parseInt(y)) {
            alert('Expense Amount can not be geterthen bank amount');
            $("#mySelect2").val('');
        }

    }
</script>