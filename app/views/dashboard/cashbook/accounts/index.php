<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>

                    <?php if ($this->session->flashdata('usingAccount')) { ?>

                        <?php echo $this->session->flashdata('usingAccount'); ?>

                    <?php } ?>
                    <a href="<?php echo site_url('cashbook/balanceStatement'); ?>" class="btn btn-warning btn-sm
                    pull-right " style="margin-left: 10px" target="_blank" title="Print"><i class="glyphicon
                    glyphicon-print"></i>
                        Print</a>

                    <a href="<?php echo site_url('cashbook/Accountcreate'); ?>" class="btn btn-primary btn-sm
                    pull-right" title="Add"><i class="glyphicon glyphicon-plus"></i> Add New</a>


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
                            <th>Opening Balance</th>
                            <th>Current Balance</th>
                            <th>Status</th>
                            <th style="width: 15%">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sl = 1; ?>
                        <?php if(!empty($accounts)){ foreach ($accounts as $account) { ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                                <td><?php echo $account->accountName; ?></td>
                                <td><?php echo $account->accountType; ?></td>
                                <td><?php echo $account->accountNumber; ?></td>
                                <td><?php echo $account->accountBranchName; ?></td>
                                <td class="text-center"><span class="badge bg-light-gray-active"><?php echo (!empty($account->openingBal)
                                            ?$account->openingBal:'0.00'); ?></span></td>
                                <td class="text-center"><span class="badge bg-blue-active"><?php echo (!empty
                                        ($account->balance)
                                            ?$account->balance:'0.00'); ?></span></td>
                                <td><?php echo ($account->softDelete==0)?'<span class="badge bg-green-active"> 
                                Active</span>':'<span class="badge bg-red-active">Inactive';
                                ?></td>
                                <td>
<!--                                    <a href="--><?php //echo base_url('cashbook/Accountshow'); ?><!--/--><?php //echo $account->accountID; ?><!--"-->
<!--                                       class="btn btn-success btn-sm"><i class="glyphicon glyphicon-share-alt"></i>-->
<!--                                        View</a>-->
                                    <a href="<?php echo base_url('cashbook/Accountedit'); ?>/<?php echo $account->accountID; ?>"
                                       class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-pencil"></i> Edit</a>

                                    <a href="<?php echo base_url('cashbook/accountsStatement'); ?>/<?php echo
                                    $account->accountID; ?>"
                                       class="btn btn-info btn-sm"><i class="glyphicon glyphicon-share-alt"></i>
                                        Ledger</a>

                                </td>
                            </tr>
                            <?php $sl++; ?>
                        <?php } } ?>
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