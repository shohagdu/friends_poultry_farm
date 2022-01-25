
<!-- Main content -->
<section class="content">

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12 pull-right">
                <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i class="glyphicon glyphicon-print"></i> Print</button>
                <a class="btn btn-danger btn-sm pull-right no-print" style="margin-right:5px;" href="<?php echo
                site_url('purchases/index') ?>"><i class="glyphicon glyphicon-backward"></i> Back</a>
                <a class="btn btn-info btn-sm pull-right no-print" style="margin-right:5px;" href="<?php echo site_url('purchases/update/'.$this->uri->segment(3)); ?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
            </div>
        </div>

        <!-- Table row -->
        <div class="col-sm-12">
            <div class="row">
                <table style="width:100%;">
                    <tr>
                        <td colspan="3">
                            <div class="text-center">
                                <div style="text-transform:uppercase;font-weight:bold;font-size:18px;"><?php echo $appConfig->company_info ?></div>
                                <div class="col-sm-12" style="font-size:11px;"><?php echo $appConfig->address ?></div>
                                <div class="col-sm-12" style="font-size:11px;"><?php echo $appConfig->contactNo ?></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:40.33%;">
                        <?php if( $info->purchase_id){ ?>
                                <b>Purchase No:</b> <?php echo $info->purchase_id; ?>
                            <?php } ?>
                            <br>
                            <b>Date:</b> <?php echo !empty($info->purchase_date)?date('d M, Y',strtotime($info->purchase_date)):''; ?>
                            <br>
                            
                         </td>
                        <td style="width:33.33%;">
                            <div style="font-weight:bold;font-size:18px;">Purchase Invoice</div>
                        </td>
                        <td style="width:26.33%;">
                            
                            
                        
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table-style"  style="width:100%;">
                    <thead>
                    <tr>
                        <th colspan="8" style="text-align: left;font-size:16px;padding: 2px;">Product Information</th>
                    </tr>
                        <tr>
                            <th style="width:5%;">SL</th>
                            <th class="text-left" >Product Name</th>
                            <th class="text-left" style="width:15%;">Brand</th>
                            <th class="text-left" style="width:15%;">Source</th>
                            <th style="width:10%;">Unit</th>
                            <th style="width:10%;">Qty</th>
                            <th style="width:10%;">Unit Price</th>
                            <th style="width:10%;">Total Price</th>

                         </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        $tAmount='0.00';
                        $tQty='0';
                        if(!empty($details)){
                         foreach ($details as $row) { 
                               if(!empty($row->product_name)){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td class="text-left"><?php echo $row->product_name." [".$row->productCode."]"; ?></td>
                                <td class="text-left" ><?php echo (!empty($row->bandTitle)?$row->bandTitle:''); ?></td>
                                <td class="text-left" ><?php echo (!empty($row->sourceTitle)?$row->sourceTitle:''); ?></td>
                                <td><?php echo (!empty($row->unitTitle)?$row->unitTitle:''); ?></td>
                                <td><?php echo $item=(!empty($row->total_item)?$row->total_item:''); $tQty+=$item; ?></td>
                                <td><?php echo (!empty($row->unit_price)?$row->unit_price:''); ?></td>
                                <td><?php echo $total=(!empty($row->total_price)?$row->total_price:''); $tAmount+=$total; ?></td>

                              
                            </tr>	
                        <?php }} } ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total Summery</th>
                            <th><?php echo $tQty ?></th>
                            <th></th>
                            <th><?php echo number_format($tAmount,2) ?></th>
                        </tr>
                    </tfoot>
                  
                </table>
                <div class="col-sm-12 margin-top-10px" >
                    <div class="row">
                        <?php if( $info->note){ ?>
                            <b>Note:</b> <?php echo $info->note; ?><br>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
