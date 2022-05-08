<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-10">
                <h4>Account Statement<h4>
            </div>
            <div class="col-xs-2 text-right">
                <button type="button" onclick="window.print();" class="no-print btn btn-warning "><i class="fa
                fa-print"></i>  Print</button>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div>
            <form action="" method="post" id="accountsReportForm">
                <div class="form-group no-print margin-bottom-none" >
                    <div class="col-sm-3 col-xs-8">
                        <label>Date</label>
                        <div class="clearfix"></div>
                        <input type="text" id="reservation" name="searchingDate" placeholder="Date" class="form-control">
                    </div>
                    <div class="col-sm-2 col-xs-4" style="margin-top:25px;">
                        <input type="hidden" name="accountID" value="<?php  echo $this->uri->segment(3) ?>">
                        <button type="button" onclick="searchingAccountsStatementReports()" class="btn btn-info search_btn" ><i
                                class="glyphicon
                            glyphicon-search" ></i> Search</button>
                    </div>

                </div>
            </form>
            <div class="clearfix"></div>
            <div style="margin-bottom: 15px"></div>
            <div class="showInfo">
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
                                        <td class="text-right">
                                            <?php echo $debit=(!empty($acBalance->debit_amount)
                                                ?$acBalance->debit_amount:'0.00')
                                            ?>
                                        </td>
                                        <td class="text-right"><?php echo $credit=(!empty($acBalance->credit_amount)
                                                ?$acBalance->credit_amount:'0.00')
                                            ?></td>
                                        <td class="text-right">
                                            <?php
                                            $initalBalance+=($debit-$credit);
                                            echo $balance=(!empty($initalBalance)
                                                ?number_format($initalBalance,2,'.',''):'0.00') ?>
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
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</section>
