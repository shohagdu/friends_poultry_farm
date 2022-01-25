<table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
    <thead>
    <tr>
        <td class="font-weight-bold"> SL</td>
        <td class="font-weight-bold"> Sales ID</td>
        <td class="font-weight-bold"> Date</td>
        <td class="font-weight-bold"> Customer Info</td>
        <td class="font-weight-bold"> Sub Total</td>
        <td class="font-weight-bold"> Discount</td>
        <td class="font-weight-bold"> Net Total</td>
        <td class="font-weight-bold"> Payment </td>
    </tr>
    </thead>
    <tbody>
    <?php
    $i              = 1;
    $tSub           = 0;
    $tDiscount      = 0;
    $tNetTotal      = 0;
    $paymentAmt     = 0;
    $tCosting       = 0;
    $tProfitLose    = 0;
    if(!empty($info)){
        foreach ($info as $row) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a href="<?php echo base_url('pos/show/'.$row->salesID) ?>" target="_blank"> <?php echo (!empty($row->invoice_no)?$row->invoice_no:''); ?></a>

                </td>
                <td nowrap="">
                    <?php echo (!empty($row->sales_date)?date('d, M, Y',strtotime($row->sales_date)):''); ?>
                </td>
                <td class="text-left">
                    <?php echo (!empty($row->customerName)?$row->customerName:'').(!empty($row->mobile)?' ['.$row->mobile.']':''); ?>
                </td>
                <td><i class="badge"><?php echo (!empty($row->sub_total)?$row->sub_total:''); $tSub+=$row->sub_total; ?></i></td>


                <td><i class="badge"><?php echo (!empty($row->discount)?$row->discount:''); $tDiscount+=$row->discount; ?></i></td>
                <td><i class="badge"><?php echo $netTotal=(!empty($row->net_total)?$row->net_total:'0.00');  $tNetTotal+=$row->net_total; ?></i></td>
                <td><i class="badge"><?php echo (!empty($row->payment_amount)?$row->payment_amount:'0.00'); $paymentAmt+=$row->payment_amount; ?></i></td>

            </tr>
            <?php
        }
    }
    ?>

    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" class="text-right">Total Summery</th>
        <th><i class="badge"><?php echo !empty($tSub)? number_format($tSub,2):'0.00'; ?></i></th>
        <th><i class="badge"><?php echo !empty($tDiscount)? number_format($tDiscount,2):'0.00'; ?></i></th>
        <th><i class="badge"><?php echo !empty($tNetTotal)? number_format($tNetTotal,2):'0.00'; ?></i></th>
        <th><i class="badge"><?php echo !empty($paymentAmt)? number_format($paymentAmt,2):'0.00'; ?></i></th>
    </tr>
    </tfoot>
</table>