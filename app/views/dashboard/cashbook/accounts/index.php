<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Accounts</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>

                    <?php if ($this->session->flashdata('usingAccount')) { ?>

                        <?php echo $this->session->flashdata('usingAccount'); ?>

                    <?php } ?>
                    <a href="<?php echo site_url('cashbook/Accountcreate'); ?>" class="btn btn-primary btn-xs pull-right" title="Add"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="5%">SL.</th>
                            <th>Account Name</th>
                            <th width="16%">Account Type</th>
                            <th>Account Number</th>
                            <th>Branch Name</th>
                            <th width="20%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($accounts as $account) { ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                                <td><?php echo $account->accountName; ?></td>
                                <td><?php echo $account->accountType; ?></td>
                                <td><?php echo $account->accountNumber; ?></td>
                                <td><?php echo $account->accountBranchName; ?></td>
                                <td>
                                    <a href="<?php echo base_url('cashbook/Accountshow'); ?>/<?php echo $account->accountID; ?>"
                                       class="btn btn-success btn-sm">View</a>
                                    <a href="<?php echo base_url('cashbook/Accountedit'); ?>/<?php echo $account->accountID; ?>"
                                       class="btn btn-primary btn-sm">Edit</a>
                                    <!--                                        <a href="-->
                                    <?php //echo base_url('cashbook/Accountdestroy'); ?><!--/-->
                                    <?php //echo $account->accountID; ?><!--" onclick="return confirm('Are You sure, Your want to delete This!')" class="btn btn-danger btn-sm">Delete</a>-->
                                </td>
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

    </div>
</section>
<!-- /.content -->