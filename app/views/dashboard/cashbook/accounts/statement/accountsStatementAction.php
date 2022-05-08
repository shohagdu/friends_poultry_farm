<table class="table  table-bordered">
    <thead>
    <tr>
        <th class="width5per">Sl.</th>
        <th class="width15per">Date</th>
        <th class="width30per">Details</th>
        <th class="text-right width15per">Debit</th>
        <th class="text-right width15per">Credit</th>
        <th class="text-right width15per">Balance</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $i=1;
        $tDebit         ='0.00';
        $tCredit        ='0.00';
        $tBalance       ='0.00';
        $initalBalance  ='0.00';
        $balance       ='0.00';
    ?>
    <tr>
        <td colspan="3" class="text-right">Carry over head balance (Initial Balance)</td>
        <td class="text-right"><?php  $tDebit += ((!empty($carryOverHeadBal) && $carryOverHeadBal > 0) ? number_format($carryOverHeadBal,2,'.',
                ''):'0.00'); echo   ((!empty($carryOverHeadBal) && $carryOverHeadBal > 0) ? number_format($carryOverHeadBal,2,'.',
                ''):'0.00'); ?></td>
        <td class="text-right"><?php  $tCredit += ((!empty($carryOverHeadBal) && $carryOverHeadBal < 0) ?
                number_format($carryOverHeadBal,2,'.',
                ''):'0.00'); echo   ((!empty($carryOverHeadBal) && $carryOverHeadBal < 0) ? number_format($carryOverHeadBal,2,'.',
                ''):'0.00'); ?></td>
        <td class="text-right"><?php  $tBalance+=$carryOverHeadBal;  echo number_format($carryOverHeadBal,2) ?></td>
    </tr>
    <?php
    if(!empty($accountBalanceHistory)){
        foreach ($accountBalanceHistory as $acBalance){
    ?>
        <tr>
            <td><?php echo $i++ ?></td>
            <td><?php echo (!empty($acBalance->payment_date)?date('d M, Y',strtotime
                ($acBalance->payment_date)):'')
                ?></td>
            <td>
                <?php echo (!empty($acBalance->remarks)?strip_tags
                    ($acBalance->remarks)." <> ":'');
                if($acBalance->parentType==8){
                    echo "Expense";
                }else {
                    echo(!empty ($transType[$acBalance->type])
                        ? $transType[$acBalance->type] : '');
                }
                echo (!empty ($acBalance->expenseTitle)? " <> ".$acBalance->expenseTitle:'') ?>
            </td>
            <td class="text-right"><?php echo $debit=(!empty($acBalance->debit_amount)
                    ?$acBalance->debit_amount:'0.00')
                ?></td>
            <td class="text-right"><?php echo $credit=(!empty($acBalance->credit_amount)
                    ?$acBalance->credit_amount:'0.00')
                ?></td>
            <td class="text-right">
                <?php
                echo $balance += (($balance+$debit)-$credit); ?>
            </td>
        </tr>

        <?php
        $tDebit+=$debit;
        $tCredit+=$credit;
        $tBalance+=$balance;
        }
    }
    ?>


    </tbody>
    <tfoot>
    <tr>
        <th colspan="3" class="text-right">Total Summery</th>
        <th class="text-right"><?php echo (!empty($tDebit)?number_format($tDebit,2):'0.00')  ?></th>
        <th class="text-right"><?php echo (!empty($tCredit)?number_format($tCredit,2):'0.00')  ?></th>
        <th class="text-right"><?php echo (!empty($tDebit-$tCredit)?number_format($tDebit-$tCredit,2):'0.00')
            ?></th>
    </tr>
    </tfoot>
</table>