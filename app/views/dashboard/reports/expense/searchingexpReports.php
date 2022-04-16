<table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
    <thead>

    <tr>
        <th style="width: 5%;">S/N</th>
        <th style="width: 15%;">Date</th>
        <th style="width: 20%;">Expense Category</th>
        <th style="width: 15%;">Account Info</th>
        <th style="width: 10%;">Remarks</th>
        <th style="width: 10%;">Exp. Amount</th>

    </tr>
    </thead>
    <tbody>
    <?php
    $i              = 1;
    $tNetTotal      = 0;
    if(!empty($info)){
        foreach ($info as $row) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td nowrap="">
                    <?php echo (!empty($row->payment_date)?date('d, M, Y',strtotime($row->payment_date)):''); ?>
                </td>
                <td class="text-left">
                    <?php echo (!empty($row->expenseTitle)?$row->expenseTitle:''); ?>
                </td>
                <td><?php echo (!empty($row->expenseBankName)?$row->expenseBankName:'');  ?></td>

                <td><?php echo (!empty($row->remarks)?$row->remarks:''); ?></td>
                <td><i class="badge"><?php echo (!empty($row->debit_amount)
                            ?$row->debit_amount:'');  $tNetTotal+=$row->debit_amount;?></i></td>

            </tr>
            <?php
        }
    }
    ?>

    </tbody>
    <tfoot>
    <tr>
        <th colspan="5" class="text-right">Total Summery</th>

        <th><i class="badge"><?php echo !empty($tNetTotal)? number_format($tNetTotal,2):'0.00'; ?></i></th>

    </tr>
    </tfoot>
</table>
