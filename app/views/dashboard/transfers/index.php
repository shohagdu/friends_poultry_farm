<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Transfers</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="12%">TransferNo</th>
                                <th width="15%">Transfer Date</th>
                                <th>From</th>
                                <th>To</th>                
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($transfers as $transfer) { ?>
                                <tr>
                                    <td><?php echo $transfer->transferNo; ?></td>
                                    <td><?php echo $transfer->transferDate; ?></td>
                                    <td><?php echo $transfer->fromWarehouseInfo->warehouseName; ?></td>
                                    <td><?php echo $transfer->toWarehouseInfo->warehouseName; ?></td>
                                    <td><a href="<?php echo base_url('transfers/show'); ?>/<?php echo $transfer->transferNo; ?>" class="btn btn-success btn-sm">View</a>
                                        <a href="<?php echo base_url('transfers/tr_edit'); ?>/<?php echo $transfer->transferNo; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="<?php echo base_url('transfers/destroy'); ?>/<?php echo $transfer->transferNo; ?>" onclick="return confirm('Are You sure, Your want to delete This!')" class="btn btn-danger btn-sm">Delete</a></td>
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
</section>
<!-- /.content -->