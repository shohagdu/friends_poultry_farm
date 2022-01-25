<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box no-border">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <button class="btn btn-danger pull-right no-print" onclick="goBack()"><i
                            class="glyphicon glyphicon-backward"></i> Back
                    </button>
                    <button class="btn btn-primary pull-right no-print" style="margin-right: 10px;" onclick="print()"><i
                            class="glyphicon glyphicon-print"></i> Print
                    </button>


                </div>
                <div class="clearfix"></div>
                <div class="box-body">
                    <table  class=' table-style width70per' >
                        <tr>
                            <th class="text-left">Shipment Name</th>
                            <td class="text-left"><?php echo (!empty($shipment_info->shipmentName)?$shipment_info->shipmentName:'')
                                ?></td>
                            <th class="text-left">Destribute Date</th>
                            <td class="text-left"><?php echo (!empty($shipment_info->destibute_dt)?$shipment_info->destibute_dt:'')
                                ?></td>
                        </tr>
                        <tr>
                            <th class="text-left">Note</th>
                            <td colspan="3" class="text-left"><?php echo (!empty($shipment_info->total_qty)?$shipment_info->total_qty:'') ?></td>
                        </tr>
                    </table>
                    <table  class=' table-style width100per' style="margin-top:10px" >
                        <thead>
                        <tr>
                            <th>S/L</th>
                            <th class="text-left">Name of Party (Member)</th>
                            <th>No. Catt</th>
                            <th>Unit Price</th>
                            <th>Sub Total</th>
                            <th>Discount</th>
                            <th>Total Payable</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if(!empty($shipment_info->shipment_details)){
                                $sl=1;
                                $tQty='0.00';
                                $tSubtotal='0.00';
                                $tDiscount='0.00';
                                $tDebitAmt='0.00';
                                foreach ($shipment_info->shipment_details as $key => $details){
                                    ?>
                                    <tr>
                                        <td><?php echo $sl++; ?></td>
                                        <td class="text-left"><?php echo $details->member_name.' ('.$details->address
                                                .')' ?></td>
                                        <td><?php echo $details->debit_qty; $tQty+=$details->debit_qty; ?></td>
                                        <td><?php echo $details->unit_price ?></td>
                                        <td><?php echo $details->sub_total; $tSubtotal+=$details->sub_total; ?></td>
                                        <td><?php echo $details->discount; $tDiscount+=$details->discount;   ?></td>
                                        <td><?php echo $details->debit_amount; $tDebitAmt+=$details->debit_amount; ?></td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>



                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th><?php echo  $tQty;  ?></th>
                                <th></th>
                                <th><?php echo  !empty($tSubtotal)?number_format($tSubtotal,2):'0.00';  ?></th>
                                <th><?php echo  !empty($tDiscount)?number_format($tDiscount,2):'0.00';  ?></th>
                                <th><?php echo  !empty($tDebitAmt)?number_format($tDebitAmt,2):'0.00';  ?></th>
                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
