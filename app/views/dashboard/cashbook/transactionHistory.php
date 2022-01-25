<?php
extract($_POST);
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Account</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url('cashbook/transactionHistory'); ?>" method="post">
                        <div class="col-sm-5">
                            <label>Account Name</label>
                            <select name="accountID" class="form-control select2" style="width: 100%;">
                                <option value="">Select Account</option>
                                <?php foreach ($accounts as $account) {
                                    $selected=(isset($accountID)&&!empty($accountID) && $accountID==$account->accountID )?"selected":"";
                                    ?>

                                    <option value="<?php echo $account->accountID; ?>" <?php echo $selected; ?>><?php echo $account->accountName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-xs-5">
                            <div class="form-group has-feedback">
                                <label>Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" value="<?php echo (isset($date)&&!empty($date)  )?$date:"";; ?>" name="date" class="form-control pull-right" id="reservation">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <br/>
                            <div class="col-xs-2">
                                <button type="submit" name="searchBtn" class="btn btn-primary btn-sm btn-sm"><i class="fa fa-search"></i>&nbsp;Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Transaction History</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <div class="box-body">
                    <table id="tbl1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Account Name</th>
                                <th>Card Number</th>
                                <th>Ref No</th>
                                <th>Type</th>
                                <th>Amount</th>
<!--                                <th>Balance</th>-->
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1;  $total = 0;
                            if(!empty($transactions)){
                            foreach ($transactions as $transaction) { ?>
                                <?php $total = $transaction->transactionAmount + $total; ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $transaction->accountName; ?></td>
                                    <td><?php echo $transaction->CardNum; ?></td>
                                    <td><?php echo $transaction->refNo; ?></td>
                                    <td><?php echo $transaction->transactionType; ?></td>
                                    <td><?php echo $transaction->transactionAmount; ?></td>
<!--                                    <td>--><?php //echo $transaction->transactionAmount; ?><!--</td>-->
                                    <td><?php echo $transaction->date; ?></td>
                                </tr>
                                <?php $sl++; ?>
                            <?php } }?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Amount:</h3>
                    <small class="pull-right" id="today"><b><?php echo $total; ?></b></small>
                </div>

            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</section>