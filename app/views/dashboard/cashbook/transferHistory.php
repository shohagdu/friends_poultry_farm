
<section class="content">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Account</h3>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url('cashbook/transactionHistory'); ?>" method="post">
                        <div class="form-group has-feedback">
                            <label>Account Name</label>
                            <select name="accountID" class="form-control select2" style="width: 100%;">
                                <option value="">Select Account</option>
                                <?php foreach ($accounts as $account) { ?>
                                    <option value="<?php echo $account->accountID; ?>"><?php echo $account->accountName; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">

                            </div>
                            <div class="col-xs-4">

                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                            </div>

                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Transaction History</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Account Name</th>
                                <th>Ref No</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php $total = 0; ?>
                            <?php foreach ($transactions as $transaction) { ?>
                                <?php $total = $transaction->transactionAmount + $total; ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><?php echo $transaction->accountName; ?></td>
                                    <td><?php echo $transaction->refNo; ?></td>
                                    <td><?php echo $transaction->transactionType; ?></td>
                                    <td><?php echo $transaction->transactionAmount; ?></td>
                                    <td><?php echo $transaction->created_at; ?></td>
                                </tr>
                                <?php $sl++; ?>
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
        <div class="col-md-1"></div>
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
<!-- /.content -->