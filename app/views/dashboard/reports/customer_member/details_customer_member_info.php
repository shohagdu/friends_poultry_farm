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
                            <th> Date</th>
                            <th> Payment By</th>
                            <th> Debit</th>
                            <th> Credit</th>
                            <th> Balance </th>
                            <th class="no-print" style="width: 10%;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($info)){
                            $i=1;
                            $tDebit='0.00';
                            $tCredit='0.00';
                            foreach ($info as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td class="text-left"><?php echo (!empty($row->sales_date)?date('d M, Y',strtotime
                                        ($row->sales_date)):'');
                                        ?></td>
                                    <td class="text-left"><?php  $paymentBy=!empty($row->payment_by)?json_decode
                                        ($row->payment_by,true):'';  ?>
                                        <table class="table-style width100per"  >
                                            <?php
                                            $paymentKey=[
                                                'cash'=>'Cash',
                                                'cash_cheque'=>'Cash Cheque',
                                                'due_cheque'=>'Due Cheque',
                                                'online_payment'=>'Online Payment',
                                            ];
                                            if(!empty($paymentBy)){
                                                foreach ($paymentBy as $key=> $value){
                                                    ?>
                                                    <tr>
                                                        <td style="padding-right:8px; " class="text-left
                                                        width70per"><?php
                                                            echo
                                                            !empty
                                                            ($paymentKey[$key])
                                                                ?$paymentKey[$key]:''; ?></td>
                                                        <td style="width:33%;"><?php echo number_format($value,2) ?></td>
                                                    </tr>
                                                <?php } } ?>
                                            </table>
                                    </td>
                                    <td class="text-right"><?php echo !empty($row->debit_amount)
                                            ?number_format($row->debit_amount,2):'0.00'; $tDebit+=$row->debit_amount;
                                    ?></td>
                                    <td class="text-right"><?php echo !empty($row->credit_amount)
                                            ?number_format($row->credit_amount,2):'0.00';
                                            $tCredit+=$row->credit_amount; ?></td>
                                    <td class="text-right"><?php echo (!empty($tDebit-$tCredit)?number_format
                                        ($tDebit-$tCredit,2):'0.00')
                                        ?></td>
                                    <td class="no-print">
                                        <?php
                                            if(!empty($row->sales_id)){
                                        ?>
                                        <a target="_blank" href="<?php echo base_url('pos/show/'.$row->sales_id)
                                        ?>" class="btn btn-info btn-xs" title="Details"><i
                                                class="glyphicon glyphicon-share-alt"></i></a>
                                        <?php } ?>
                                    </td>

                                </tr>
                                <?php
                            }
                        }else{
                            echo "<tr><td colspan='7' class='red'>No Data Exist</td></tr>";
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
