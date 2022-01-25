
<!-- Main content -->
<section class="content">

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12 pull-right">
                <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i class="glyphicon glyphicon-print"></i> Print</button>
                <a class="btn btn-danger btn-sm pull-right no-print" style="margin-right:5px;" href="<?php echo
                site_url('transfer/index') ?>"><i class="glyphicon glyphicon-backward"></i> Back</a>
                <a class="btn btn-info btn-sm pull-right no-print" style="margin-right:5px;" href="<?php echo site_url('transfer/update/'.$this->uri->segment(3)); ?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
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
                            <table class="table-style width80per margin-bottom" >
                                <tr>
                                    <td class="text-left">Transfer No</td>
                                    <td class="text-left"><?php echo $info->transfer_id; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">Date</td>
                                    <td class="text-left"><?php echo !empty($info->transfer_date)?date('d M, Y',strtotime
                                        ($info->transfer_date)):''; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">From Outlet</td>
                                    <td class="text-left"><?php echo !empty($info->from_outlet_name)?$info->from_outlet_name:''; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-left">To Outlet</td>
                                    <td class="text-left"><?php echo !empty($info->to_outlet_name)?$info->to_outlet_name:''; ?></td>
                                </tr>
                            </table>
                            
                         </td>
                        <td style="width:33.33%;">
                            <div style="font-weight:bold;font-size:18px; text-align: center;">Transfer Invoice</div>
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
                        <th colspan="6" style="text-align: left;font-size:16px;padding: 2px;">Product Information</th>
                    </tr>
                        <tr>
                            <th style="width:5%;">SL</th>
                            <th class="text-left" >Product Name</th>
                            <th class="text-left" style="width:10%;">Brand</th>
                            <th class="text-left" style="width:10%;">Source</th>
                            <th style="width:10%;">Qty</th>
                            <th style="width:10%;">Unit</th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        if(!empty($details)){
                         foreach ($details as $row) { 
                               if(!empty($row->product_name)){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td class="text-left"><?php echo $row->product_name." [".$row->productCode."]"; ?></td>
                                <td class="text-left" ><?php echo (!empty($row->bandTitle)?$row->bandTitle:''); ?></td>
                                <td class="text-left" ><?php echo (!empty($row->sourceTitle)?$row->sourceTitle:''); ?></td>
                                <td><?php echo (!empty($row->total_item)?$row->total_item:''); ?></td>
                                <td><?php echo (!empty($row->unitTitle)?$row->unitTitle:''); ?></td>
                              
                            </tr>	
                        <?php }} } ?>

                    </tbody>
                  
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
