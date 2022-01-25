<!-- Content Header (Page header) -->
<section class="content-header">

</section>

<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Sales</h3>
            <?php if ($this->session->flashdata('msg')) { ?>

                <?php echo $this->session->flashdata('msg'); ?>

            <?php } ?>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Client Name</th>
                        <th>Warehouse</th>
                        <th>Sales Date</th>
                        <th>Net Total</th>
                        <th>Due Amount</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($sales as $sale) { ?>
                        <tr>
                            <td><?php echo $sale->invoiceNo; ?></td>
                            <td><?php echo $sale->clientName; ?></td>
                            <td><?php echo $sale->warehouseName; ?></td>
                            <td><?php echo $sale->salesDate; ?></td>
                            <td><?php echo $sale->netTotal; ?></td>
                            <td><?php echo $sale->dueAmount; ?></td>
                            <td>
                                <a style="margin-right: 5px;" href="<?php echo base_url('sales/show'); ?>/<?php echo $sale->invoiceNo; ?>" class="btn btn-success btn-sm pull-left">View</a> 
                                <?php if ($sale->returnValue <= 0) { ?>
                                              <a style="margin-right: 5px;" href="<?php echo base_url('sales/returnSale'); ?>/<?php echo $sale->invoiceNo; ?>" class="btn btn-danger btn-sm pull-left">Return</a>
                                <?php } ?>
                                <a style="margin-right: 5px;" href="<?php echo base_url('sales/edit'); ?>/<?php echo $sale->invoiceNo; ?>" class="btn btn-primary btn-sm pull-left">Edit</a> 

                                <a href="<?php echo base_url('sales/destroy'); ?>/<?php echo $sale->invoiceNo; ?>" onclick="return confirm('Are You sure, Your want to delete This!')" class="btn btn-danger btn-sm pull-left">Delete</a></td>
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
</section>
<!-- /.content -->