<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i
                            class="glyphicon glyphicon-print"></i> Print</button>
                </div>
                <div class="clearfix"></div>
                <div class="box-body no-border">
                    <div class="showDailyStatements">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Sales Information: </h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h4>Date: <?php echo date('d M, Y') ?></h4>
                            </div>
                        </div>
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
                                <td class="font-weight-bold"> Adjustment(-)</td>
                                <td class="font-weight-bold"> Payment </td>

                                <td class="font-weight-bold"> Costing Amt </td>
                                <td class="font-weight-bold"> Profit/Lose Amt </td>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i              = 1;
                            $j              = 1;
                            $k              = 1;
                            $tSub           = 0;
                            $tDiscount      = 0;
                            $tNetTotal      = 0;
                            $tAjustTotal    = 0;
                            $paymentAmt     = 0;
                            $tCosting       = 0;
                            $tProfitLose    = 0;
                            if(!empty($sales)){
                                foreach ($sales as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <?php echo (!empty($row->invoice_no)?$row->invoice_no:''); ?>

                                        </td>
                                        <td nowrap="">
                                            <?php echo (!empty($row->sales_date)?date('d, M, Y',strtotime($row->sales_date)):''); ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo (!empty($row->customerName)?$row->customerName:'').(!empty($row->mobile)?' ['.$row->mobile.']':''); ?>
                                        </td>
                                        <td><?php echo (!empty($row->sub_total)?$row->sub_total:''); $tSub+=$row->sub_total; ?></td>


                                        <td><?php echo (!empty($row->discount)?$row->discount:''); $tDiscount+=$row->discount; ?></td>
                                        <td><?php echo $netTotal=(!empty($row->net_total)?$row->net_total:'0.00');  $tNetTotal+=$row->net_total; ?></td>
                                        <td><?php echo $ajustmentTotal=(!empty($row->remaining_due_make_discount)?$row->remaining_due_make_discount:'0.00');  $tAjustTotal+=$ajustmentTotal; ?></td>

                                        <td><?php echo $payment=(!empty($row->payment_amount)?$row->payment_amount:'0.00'); $paymentAmt+=$row->payment_amount; ?></td>
                                        <td>
                                            <?php echo $purchaseAmt=(!empty($row->getPurchaseAmount)?$row->getPurchaseAmount:'0.00'); $tCosting+=$row->getPurchaseAmount; ?>
                                        </td>
                                        <td>
                                            <?php
                                                $profitLose=(!empty($row->net_total)?($netTotal-$purchaseAmt):'0.00');
                                                echo number_format($profitLose,2);
                                                $tProfitLose+=$profitLose;
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total Sales Summery</th>
                                    <th><i class="badge"><?php echo !empty($tSub)? number_format($tSub,2):'0.00'; ?></i></th>
                                    <th><i class="badge"><?php echo !empty($tDiscount)? number_format($tDiscount,2):'0.00'; ?></i></th>
                                    <th><i class="badge"><?php echo !empty($tNetTotal)? number_format($tNetTotal,2):'0.00'; ?></i></th>
                                    <th><i class="badge"><?php echo !empty($tAjustTotal)? number_format($tAjustTotal,2):'0.00'; ?></i></th>
                                    <th><i class="badge"><?php echo !empty($paymentAmt)? number_format($paymentAmt,2):'0.00'; ?></i></th>

                                    <th><i class="badge"><?php echo !empty($tCosting)? number_format($tCosting,2):'0.00'; ?></i></th>
                                    <th><i class="badge"><?php echo !empty($tProfitLose)? number_format($tProfitLose,2):'0.00'; ?></i></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Customer Due Collection/Closing Discount/Cash Deposit to Customer Information: </h4>
                            </div>
                        </div>
                        <table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
                            <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Date</th>
                                    <th>Trans. Code </th>
                                    <th>Customer Name </th>
                                    <th>Trans. Type </th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $tCollection    = '0.00';
                                    $tBalanced      = '0.00';
                                    $bal            = '0.00';
                                    if(!empty($customerCollection)){
                                        foreach ($customerCollection as $collection){
                                ?>
                                            <tr>
                                                <td><?php echo $j++ ?></td>
                                                <td class="text-left">
                                                    <?php echo (!empty($collection->payment_date)
                                                        ?$collection->payment_date:'')
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo (!empty($collection->transCode)?$collection->transCode:'')
                                                    ?>
                                                </td>
                                                <td class="text-left">
                                                    <?php echo (!empty($collection->customer_info)?$collection->customer_info:'')
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo (!empty($collection->transType)?$collection->transType:'')
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    echo (!empty($collection->amount)?$collection->amount:'');
                                                    $tCollection+=$collection->amount;
                                                    ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    $type= (!empty($collection->type)?$collection->type:'');
                                                    if($type==3) {
                                                        $bal=(!empty($collection->amount) ? $collection->amount : '');
                                                    }elseif ($type==11){
                                                        $bal=(!empty($collection->amount) ? "-".$collection->amount :
                                                            '');
                                                    }

                                                         echo number_format($tBalanced+=$bal,2);
                                                    ?>
                                                </td>

                                            </tr>
                                <?php
                                        }
                                    }
                                ?>



                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total Due Collection/Closing Discount/Cash
                                        Deposit Summery</th>
                                    <th class="text-center" colspan="2"><?php echo (!empty($tBalanced)?number_format
                                        ($tBalanced,
                                            2):"") ?></th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Purchase (Supplier) Information: </h4>
                            </div>
                        </div>
                        <table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;" >
                            <thead>
                            <tr>
                                <th>S/L</th>
                                <th>Date</th>
                                <th>Trans. Code </th>
                                <th>Supplier Name </th>
                                <th>Products </th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $tPurchase='0.00';
                                if(!empty($purchaseInfo)){
                                    foreach ($purchaseInfo as $purchase){
                                        ?>
                                        <tr>
                                            <td><?php echo $k++ ?></td>
                                            <td class="text-left">
                                                <?php echo (!empty($purchase->purchase_date)
                                                    ?date('d M, Y',strtotime($purchase->purchase_date)):'')
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($purchase->purchase_id)?$purchase->purchase_id:'')
                                                ?>
                                            </td>
                                            <td class="text-left">
                                                <?php echo (!empty($purchase->supplierName)?$purchase->supplierName:'');
                                                echo (!empty($purchase->supplierMobile)?" [".$purchase->supplierMobile."]":'')
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($purchase->productCodesInfo)?$purchase->productCodesInfo:'')
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <?php  echo $purchaseAmnt=(!empty($purchase->sumTotalPurchase)
                                                    ?$purchase->sumTotalPurchase:'');
                                                $tPurchase+=$purchaseAmnt;
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total Purchase (Supplier) Summery</th>
                                    <th class="text-right"> <span class='badge'><?php echo (!empty($tPurchase)
                                                ?number_format($tPurchase,2):''); ?></span></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Payment (Supplier) Information: </h4>
                            </div>
                        </div>
                        <table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
                            <thead>

                            <tr>
                                <th style="width: 5%;">S/N</th>
                                <th style="width: 15%;">Date</th>
                                <th style="width: 15%;">Trans. ID</th>
                                <th style="width: 15%;">Supplier Name</th>
                                <th style="width: 10%;">Remarks</th>
                                <th style="width: 10%;">Amount</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $l              = 1;
                            $tPayemnt       = 0;
                            if(!empty($supplierPayment)){
                                foreach ($supplierPayment as $payment) {
                                    ?>
                                    <tr>
                                        <td><?php echo $l++; ?></td>
                                        <td nowrap="">
                                            <?php echo (!empty($payment->payment_date)?date('d, M, Y',strtotime($payment->payment_date)):''); ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo (!empty($payment->transCode)?$payment->transCode:''); ?>
                                        </td>
                                        <td><?php echo (!empty($payment->member_name)?$payment->member_name:'');  ?></td>

                                        <td><?php echo (!empty($paymentremarks)?$payment->remarks:''); ?></td>
                                        <td class="text-right"> <?php echo (!empty($payment->credit_amount)
                                                    ?$payment->credit_amount:'');  $tPayemnt+=$payment->credit_amount;
                                                    ?></td>

                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total Payment (Supplier) Summery</th>
                                <th class="text-right"><i class="badge" ><?php echo !empty($tPayemnt)? number_format($tPayemnt,2):'0
                                .00'; ?></i></th>
                            </tr>
                            </tfoot>
                        </table>

                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Expense Information: </h4>
                            </div>
                        </div>
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
                            $l              = 1;
                            $tNetTotal      = 0;
                            if(!empty($expense)){
                                foreach ($expense as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $l++; ?></td>
                                        <td nowrap="">
                                            <?php echo (!empty($row->payment_date)?date('d, M, Y',strtotime($row->payment_date)):''); ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo (!empty($row->expenseTitle)?$row->expenseTitle:''); ?>
                                        </td>
                                        <td><?php echo (!empty($row->expenseBankName)?$row->expenseBankName:'');  ?></td>

                                        <td><?php echo (!empty($row->remarks)?$row->remarks:''); ?></td>
                                        <td class="text-right"><i class="badge"><?php echo (!empty($row->debit_amount)
                                                    ?$row->debit_amount:'');  $tNetTotal+=$row->debit_amount;?></i></td>

                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="5" class="text-right">Total Expense  Summery</th>

                                <th class="text-right"><i class="badge"><?php echo !empty($tNetTotal)? number_format($tNetTotal,2):'0.00'; ?></i></th>

                            </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
