<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header" >
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <a href="<?php echo base_url('/reports/dateWisePurchse') ?>" style="margin-left: 5px" class="btn btn-warning btn-sm pull-right no-print" ><i
                                class="glyphicon glyphicon-refresh"></i> Refresh</a>
                    <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i
                            class="glyphicon glyphicon-print"></i> Print</button>


                </div>
                <form action="" method="post" id="purchaseReportForm">
                    <div class="form-group no-print">
                        <div class="col-sm-3">
                            <label>Date</label>
                            <div class="clearfix"></div>
                            <input type="text" id="reservation" name="searchingDate" placeholder="Date" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label>Purchase ID</label>
                            <div class="clearfix"></div>
                            <input type="text" id="purchaseID" name="purchaseID" placeholder="Enter Purchase ID" class="form-control purchaseNumber">
                        </div>



                        <div class="col-sm-2" style="margin-top:25px;">
                            <button type="button"  onclick="searchingPurchaseReports()" class="btn btn-info searchBtn" ><i
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
                                    <td class="font-weight-bold"> Purchase ID</td>
                                    <td class="font-weight-bold"> Date</td>
                                    <td class="font-weight-bold"> Product Info</td>
                                    <td class="font-weight-bold"> Total Purchase  </td>
                                    <td class="font-weight-bold"> Note  </td>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $tPurchase=0;
                                $i=1;
                                if(!empty($info)){
                                    foreach ($info as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <?php echo (!empty($row->purchase_id)?$row->purchase_id:''); ?>
                                            </td>

                                            <td nowrap="">
                                                <?php echo (!empty($row->purchase_date)?date('d, M, Y',strtotime($row->purchase_date)):''); ?>
                                            </td>
                                            <td>
                                                <?php echo (!empty($row->productCodesInfo)?$row->productCodesInfo:''); ?>
                                            </td>
                                            <td><i class="badge"><?php echo $totalPruchase=(!empty($row->totalPrice)?number_format($row->totalPrice,2,'.',''):'0.00'); $tPurchase+=$totalPruchase ?></i></td>
                                            <td>
                                                <?php echo (!empty($row->note)?$row->note:''); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Total Summery</th>
                                    <th><i class="badge"><?php echo number_format($tPurchase,2); ?></i></th>
                                    <th></th>

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
