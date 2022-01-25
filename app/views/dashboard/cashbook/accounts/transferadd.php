<section class="content">
    <div class="row">


        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div >
                        <h3 class="box-title">Opening Balance</h3>
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg'); ?>
                        <?php } ?>

                        <a href="<?php echo site_url('cashbook/transferHistory'); ?>"
                           class="btn btn-primary btn-sm pull-right">Transfer List</a>

                    </div>
                </div>
                <div class="box-body">
                    <div class="col-sm-offset-2 col-md-8">
                        <form action="<?php echo base_url('cashbook/addbalancetransfer'); ?>" method="post">
                            <div class="form-group">
                                <?php
                                $this->db->select('*');
                                $this->db->from('tbl_pos_accounts');
                                $this->db->where('softDelete !=', 1);
                                $query = $this->db->get();
                                $result = $query->result_array();
                                ?>
                                <label>From Account</label>
                                <select name="fromtransactionAccountID" onchange="myFunction()" id="from_id"
                                        class="form-control select2 bank_id" style="width: 100%;">
                                    <option value="">Select Account</option>
                                    <?php foreach ($result as $account) { ?>
                                        <option value="<?php echo $account['accountID']; ?>">
                                            <?php echo $account['accountName']; ?>
                                            <?php echo $account['accountNumber']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label> Available Balance</label>
                                <input name="transactionAmount" id="mySelect" onkeyup="myFunction()"
                                       class="form-control av_amount" readonly placeholder="Available Balance">
                            </div>
                            <div class="form-group">
                                <label>To Account</label>
                                <?php
                                $this->db->select('*');
                                $this->db->from('tbl_pos_accounts');
                                $this->db->where('softDelete !=', 1);
                                $query = $this->db->get();
                                $results = $query->result_array();
                                ?>
                                <select name="totransactionAccountID" id="to_id" onchange="myFunctions()"
                                        class="form-control select2" style="width: 100%;">
                                    <option value="">Select Account</option>
                                    <?php foreach ($results as $accounts) { ?>
                                        <option value="<?php echo $accounts['accountID']; ?>">
                                            <?php echo $accounts['accountName']; ?>
                                            <?php echo $accounts['accountNumber']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Amount</label>
                                <input name="transactionAmount" id="mySelect2" onkeyup="myFunction()"
                                       class="form-control" placeholder="Amount" required>
                            </div>
                            <div class="form-group has-feedback">
                                <label> Available Balance</label>
                                <input name="cDate" id="datepicker" class="form-control"
                                       value="<?php echo date('Y-m-d') ?>">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Note</label>
                                <textarea class="textarea" name="transactionNote" placeholder="Note"
                                          style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</section>

<script>


    function myFunctions() {
        var from_id = document.getElementById("from_id").value;
        var to_id = document.getElementById("to_id").value;
        if (from_id == to_id) {
            alert('Opps !! Bank can not be same');
            setTimeout(refresh, 10000);
        }
    }
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
</script>
<script>
    function myFunction() {
        var bnkamount = document.getElementById("mySelect").value;
        var expense = document.getElementById("mySelect2").value;
        if (parseInt(expense) > parseInt(bnkamount)) {
            alert('Expense Amount can not be geterthen bank amount');
            $("#mySelect2").val('');
        }

    }
</script>