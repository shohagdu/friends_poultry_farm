<style type="text/css">
    address p {
        margin: 0px;
    }
    @media print {
        .no-print{
            display: none;
        }
    }
</style>

<!-- Main content -->
<section class="content">

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-10">
                <h2 class="page-header">
                    Payment Collection Invoice
                    <small class="pull-right" id="today"></small>
                </h2>
            </div>
            <div class="col-xs-2 no-print">
                <button class="btn btn-info btn-sm " onclick="window.print();"> <i class="glyphicon glyphicon-print"></i> Print</button>
                <a class="btn btn-danger btn-sm" href="<?php echo site_url('Suppliers/supplier_payment_summary/'.$supplierInfo['supplierID']) ?>" > <i class="glyphicon glyphicon-print"></i> Back</a>

            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="col-sm-12">
            <table style="width:100%;">
                <tr>
                    <td style="width:40%;">
                        Supplier
                        <address>
                            <strong><?php echo $supplierInfo['supplierName']; ?></strong><br>
                            Phone: <?php echo $supplierInfo['supplierPhone']; ?><br>
                            Email: <?php echo $supplierInfo['supplierEmail']; ?><br>
                            <?php echo $supplierInfo['supplierAddress']; ?><br>
                        </address>
                    </td>
                    <td style="width:20%;"></td>
                    <td style="width:40%;text-align:right;vertical-align:top;"> <b>Date:</b> <?php echo $paymentInfo['date']; ?></td>
                </tr>
            </table>


        </div>

        <div class="row">
            <div class="col-xs-12">
                        <?php
                        $previousDue=$paymentInfo['totalDueAmount'];
                        $exDue=explode("-",$previousDue);

                        $presentDue=$paymentInfo['presentDue'];
                        $presentDueExp=explode("-",$presentDue);
                        $countDue=count($exDue);
                        $countPresentDue=count($presentDueExp);
                        ?>
                        <table class="table" style="margin-left:50%;width:40%;" >
                            <tr>
                                <th style="width:71%">Previous <?php echo ($countDue=='2')?'Advacne': 'Due'; ?>:</th>
                                <td><?php echo ($countDue=='2') ? $exDue[1] : $paymentInfo['totalDueAmount']; ?></td>
                            </tr>
                            <tr>
                                <th>Payment:</th>
                                <td><?php echo $paymentInfo['amount']; ?></td>
                            </tr>
                            <tr>
                                <th>Present <?php echo ($countPresentDue=='2')?'Advacne': 'Due'; ?>:</th>
                                <td><?php echo ($countDue=='2') ? $presentDueExp[1] : $paymentInfo['presentDue']; ?></td>
                            </tr>

                        </table>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-8">

                <?php
                if($paymentInfo['note']!=''):
                ?>
                <b>Note:</b> <?php echo $paymentInfo['note']; ?>
                <?php endif ?>

            </div>
            <!-- /.col -->

            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

</section>
