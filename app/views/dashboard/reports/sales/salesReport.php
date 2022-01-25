<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header" >
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i
                            class="glyphicon glyphicon-print"></i> Print</button>
                </div>
                <form action="" method="post" id="salesReportForm">
                    <div class="form-group no-print">
                        <div class="col-sm-3">
                            <label>Date</label>
                            <div class="clearfix"></div>
                            <input type="text" id="reservation" name="searchingDate" placeholder="Date" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label>Sales ID</label>
                            <div class="clearfix"></div>
                            <input type="text" id="salesID" name="salesID" placeholder="Enter Sales ID" class="form-control invoiceNumber">
                        </div>



                        <div class="col-sm-2" style="margin-top:25px;">
                            <button type="button" onclick="searchingSalesReport()" class="btn btn-info" ><i
                                    class="glyphicon
                            glyphicon-search" ></i> Search</button>
                        </div>

                    </div>
                </form>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    <div id="stock_info_data">
                        <table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
                            <thead>
                            <tr>
                                <td class="font-weight-bold"> SL</td>
                                <td class="font-weight-bold"> Sales ID</td>
                                <td class="font-weight-bold"> Date</td>
                                <td class="font-weight-bold"> Product Info</td>
                                <td class="font-weight-bold"> Unit Sales Price</td>
                                <td class="font-weight-bold"> Unit Purchase Price</td>
                                <td class="font-weight-bold"> Qty</td>
                                <td class="font-weight-bold"> Total Sales  </td>
                                <td class="font-weight-bold"> Total Purchase  </td>
                                <td class="font-weight-bold"> Profit /Lose </td>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $tPurchase=0;
                            $tSale=0;
                            $profiteLose=0;
                            $i=1;
                            if(!empty($info)){
                                foreach ($info as $row) {
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
                                            <?php echo $row->name.' ['.$row->productCode.']'; ?>
                                            <?php echo $row->bandTitle; ?>
                                            <?php echo (!empty($row->sourceTitle)?", ".$row->sourceTitle:''); ?>
                                            <?php echo (!empty($row->ProductTypeTitle)?", ".$row->ProductTypeTitle:''); ?>
                                            <div class="clearfix"></div>


                                        </td>
                                        <td><i class="badge"><?php echo (!empty($row->unit_price)?$row->unit_price:''); ?></i></td>


                                        <td><i class="badge"><?php echo (!empty($row->purchaseAmtForSales)?$row->purchaseAmtForSales:''); ?></i></td>
                                        <td><i class="badge"><?php echo (!empty($row->total_item)?$row->total_item:''); ?></i></td>
                                        <td><i class="badge"><?php echo $totalSales=(!empty($row->total_price)?$row->total_price:''); $tSale+=$totalSales; ?></i></td>
                                        <td><i class="badge"><?php echo $totalPurchase=(!empty($row->total_item*$row->purchaseAmtForSales)?$row->total_item*$row->purchaseAmtForSales:''); $tPurchase+=$totalPurchase; ?></i></td>

                                        <td><i class="badge"><?php echo (!empty($row->profileAmount)?$row->profileAmount:''); $profiteLose+=$row->profileAmount; ?></i></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="7" class="text-right">Total Summery</th>
                                    <th><i class="badge"><?php echo number_format($tSale,2); ?></i></th>
                                    <th><i class="badge"><?php echo number_format($tPurchase,2); ?></i></th>
                                    <th><i class="badge"><?php echo number_format($profiteLose,2); ?></i></th>
                                </tr>
                                <tr>
                                    <th colspan="9" class="text-right">Total Discount(-)</th>
                                    <th><i class="badge"><?php echo $totalDiscount= (!empty($discountAdjustmentInfo->totalDiscount)? number_format($discountAdjustmentInfo->totalDiscount,2,'.',''):'0'); ?></i></th>
                                </tr>
                                <tr>
                                    <th colspan="9" class="text-right">Total Adjustment(-)</th>
                                    <th><i class="badge"><?php echo $totalAdjusment= (!empty($discountAdjustmentInfo->totalAdjustmentDiscount)? number_format($discountAdjustmentInfo->totalAdjustmentDiscount,2,'.',''):'0'); ?></i></th>
                                </tr>
                                 <tr>
                                    <th colspan="9" class="text-right">Total Net Profit/Lose</th>
                                    <th><i class="badge"><?php echo number_format($profiteLose-($totalDiscount+$totalAdjusment),2); ?></i></th>
                                </tr>


                            </tfoot>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
