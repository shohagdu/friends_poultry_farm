<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box no-border" >
                <div class="box-header">
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <button class="btn btn-warning btn-sm pull-right no-print"  onclick="goBack()" ><i
                            class="glyphicon glyphicon-backward"></i> Back</button>
                    <button class="btn btn-primary btn-sm pull-right no-print" style="margin-right:5px;"
                            onclick="window
                    .print()
"><i
                            class="glyphicon glyphicon-print"></i> Print</button>


                </div>

                <div class="clearfix"></div>
                <div class="box-body">
                    <table class="table-style width70per"  style="margin-bottom:10px;">
                        <tr>
                            <th class="text-left width20per" >Name</th>
                            <td class="text-left width30per"><?php echo (!empty($customer_info->name)
                                    ?$customer_info->name:'')
                                ?></td>
                            <th class="text-left width20per">Mobile</th>
                            <td class="text-left width30per"><?php echo (!empty($customer_info->mobile)
                                    ?$customer_info->mobile:'') ?></td>
                        </tr>
                        <tr>
                            <th class="text-left">Email</th>
                            <td class="text-left"><?php echo (!empty($customer_info->email)?$customer_info->email:'') ?></td>
                            <th class="text-left">Date of Birth</th>
                            <td class="text-left"><?php echo (!empty($customer_info->date_of_birth)
                                    ?date('d M, Y',strtotime($customer_info->date_of_birth)):'')
                                ?></td>
                        </tr>
                        <tr>
                            <th class="text-left">Address</th>
                            <td class="text-left"><?php echo (!empty($customer_info->address)?$customer_info->address:'') ?></td>
                            <th class="text-left">Remarks</th>
                            <td class="text-left"><?php echo (!empty($customer_info->remarks)?$customer_info->remarks:'') ?></td>
                        </tr>


                    </table>
                    <table  class="table-style width100per" >
                        <thead>
                        <tr>
                            <th> SL</th>
                            <th class="width10per"> Type</th>
                            <th class="width10per"> Date</th>
                            <th class="width10per"> Shipment No</th>
                            <th> Stock In</th>
                            <th> Out(Received By Party)</th>
                            <th> Unit Price </th>
                            <th> Sub Total </th>
                            <th> Discount </th>
                            <th> Billing Amount  </th>
                            <th class="width20per"> Payment Receive (Payment By Party) </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $tDebitQty='0';
                        $tCreditQty='0';
                        $debitAmt='0.00';
                        $creditAmt='0.00';
                        if(!empty($info)){
                            $i=1;
                            foreach ($info as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php
                                        if($row->type==1){
                                            echo "Stock IN";
                                        }elseif($row->type==2){
                                            echo "Stock OUT";
                                        }elseif($row->type==3){
                                            echo "Payment Received";
                                        }
                                    ?></td>
                                    <td class="text-left"><?php
                                        if(!empty($row->trans_date)) {
                                            echo(!empty($row->trans_date) ? date('d M, Y', strtotime
                                            ($row->trans_date)) : '');
                                        }else{
                                            echo(!empty($row->destibute_dt) ? date('d M, Y', strtotime
                                            ($row->destibute_dt)) : '');
                                        }

                                        ?></td>
                                    <td class="text-left"><?php echo (!empty($row->shipmentTitle)?$row->shipmentTitle:'');
                                        ?></td>


                                    <td class="text-right"><?php echo !empty($row->debit_qty)?number_format
                                        ($row->debit_qty,0):'-'; $tDebitQty+=$row->debit_qty; ?></td>
                                    <td class="text-right"><?php echo !empty($row->credit_qty)?number_format
                                        ($row->credit_qty,0):'-'; $tCreditQty+=$row->credit_qty; ?></td>

                                    <td class="text-right"><?php echo !empty($row->unit_price)?number_format($row->unit_price,2):'-';  ?></td>
                                    <td class="text-right"><?php echo !empty($row->sub_total)?number_format($row->sub_total,2):'-';  ?></td>
                                    <td class="text-right"><?php echo !empty($row->discount)?number_format($row->discount,2):'-';  ?></td>


                                    <td class="text-right"><?php echo !empty($row->debit_amount)
                                            ?number_format($row->debit_amount,2):'-'; $debitAmt+=$row->debit_amount;
                                      ?></td>
                                    <td class="text-right"><?php echo !empty($row->credit_amount) ?number_format
                                        ($row->credit_amount,2):'-'; $creditAmt+=$row->credit_amount;
                                      ?></td>

                                </tr>
                                <?php
                            }
                        }else{
                            echo "<tr><td colspan='8' class='red'>No Data Exist</td></tr>";
                        }
                        ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4">Total Summery</th>
                                <th class="text-right"><?php echo (!empty($tDebitQty)?$tDebitQty:'0') ?></th>
                                <th class="text-right"><?php echo (!empty($tCreditQty)?$tCreditQty:'0') ?></th>
                                <th colspan="3"></th>
                                <th class="text-right"><?php echo (!empty($debitAmt)?number_format($debitAmt,2):'0.00') ?></th>
                                <th class="text-right"><?php echo (!empty($creditAmt)?number_format($creditAmt,2):'0.00') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    <table class="table-style width70per"  style="margin-top:10px;">
                        <tr>
                            <th class=" " colspan="2" >Summery</th>
                            <th class="text-center width30per">Balance</th>
                        </tr>
                         <tr>
                            <th class="text-left width40per " >Total Stock In (+)</th>
                            <td class="width30per"> <span class="badge bg-yellow" > <?php echo (!empty($tDebitQty)?$tDebitQty:'0') ?></span></td>
                             <td class="width30per" rowspan="2"><span class="badge bg-green"> <?php echo (!empty
                                     ($tDebitQty-$tCreditQty)?$tDebitQty-$tCreditQty:'0') ?></span></td>
                        </tr>

                         <tr>
                            <th class="text-left ">Total Stock Out (-)</th>
                            <td > <span class="badge bg-red"> <?php echo (!empty($tCreditQty)?$tCreditQty:'0') ?></span></td>
                        </tr>
                        <tr>
                            <th class="text-left " >Total Billing Amount (-)</th>
                            <td> <span class="badge bg-yellow"> <?php echo (!empty($debitAmt)?number_format($debitAmt,2):'0.00') ?></span></td>
                             <td rowspan="2"><span class="badge bg-green"> <?php  echo
                                     ((!empty($debitAmt-$creditAmt) ) ?number_format($debitAmt-$creditAmt,2):'0.00') ?></span></td>
                        </tr>

                         <tr>
                            <th class="text-left ">Payment Receive (Payment By Party) (+)</th>
                            <td > <span class="badge bg-red"> <?php echo (!empty($creditAmt)?number_format($creditAmt,2):'0.00') ?></span></td>
                        </tr>





                    </table>

                </div>
            </div>
        </div>

    </div>
</section>
