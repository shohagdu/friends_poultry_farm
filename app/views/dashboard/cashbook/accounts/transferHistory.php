<!-- Main content -->
<section class="content">
<div class="row">
      <div class="col-md-12">

            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <h3 class="box-title">Transfer History</h3>
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg'); ?>
                        <?php } ?>

                        <a href="<?php echo site_url('cashbook/transferadd'); ?>" class="btn btn-primary btn-sm pull-right">Add
                            Transfer</a>

                    </div>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>SL.</th>
                            <th>Date</th>
                            <th>From Bank</th>
                            <th>To Bank</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sl = 1;
                        foreach ($trnsfrlist as $each_tr) {
                            ?>
                            <tr>
                                <td><?php echo $sl++; ?></td>
                                <td><?php echo $each_tr['date']; ?></td>
                                <td>
                                    <?php
                                    $bnk_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_accounts', 'accountID', $each_tr['frmbnk']);
                                    echo $bnk_name['accountName'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $bnks_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_accounts', 'accountID', $each_tr['transactionAccountID']);
                                    echo $bnks_name['accountName'];
                                    ?>
                                </td>
                                <td><?php echo $each_tr['transactionAmount']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->