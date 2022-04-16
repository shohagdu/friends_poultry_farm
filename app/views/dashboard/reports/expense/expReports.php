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
                <form action="" method="post" id="expReportForm">
                    <div class="form-group no-print">
                        <div class="col-sm-3">
                            <label>Date</label>
                            <div class="clearfix"></div>
                            <input type="text" id="reservation" name="searchingDate" placeholder="Date" class="form-control">
                        </div>

                        <div class="col-sm-2" style="margin-top:25px;">
                            <button type="button" onclick="searchingDailySalesReports()" class="btn btn-info search_btn" ><i
                                    class="glyphicon
                            glyphicon-search" ></i> Search</button>
                        </div>

                    </div>
                </form>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <div id="infoDataShow">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
