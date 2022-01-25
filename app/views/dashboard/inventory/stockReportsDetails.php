<style>
    input{
        width:60px !important;
    }
    @media print {
        .no-print {
            display: none;
        }

        #wrapper {
            max-width: 480px;
            width: 100%;
            min-width: 250px;
            margin: 0 auto;
        }

        .no-border {
            border: none !important;
        }

        .border-bottom {
            border-bottom: 1px solid #ddd !important;
        }
    }
	#tableInfo tr th{text-align: center;
                border:1px solid lightgray!important;
                margin: 0px!important;
                padding: 0px!important;

    }
    #tableInfo tr td{
        text-align: center;
        border:1px solid lightgray!important;
        margin: 0px!important;
        padding: 0px!important;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box no-border">
                <div class="box-header with-border">
                    <div class="col-sm-4"> <h3 class="box-title"><?php echo $title;?></h3></div>
                    <div class="col-sm-8 no-print">

                    <a href="<?php echo site_url('inventory/stockReports'); ?>" class="btn btn-danger btn-xs pull-right" title="Add"><i class="glyphicon glyphicon-backward"></i> Back </a>
                        <button class="btn btn-info btn-xs pull-right" style="margin-right:10px;" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
                    </div>
                </div>
                <div class="box-body no-border">
                    <div class=" col-sm-12">
                        <table id="tableInfo" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th colspan="9">Date: <?php  if(!empty($get_all_used_detais)){ echo  $get_all_used_detais[0]->use_date; }?></th>


                            </tr>
                            <tr>
                                <th>S/L</th>
                                <th>Product</th>
                                <th>Previous Qty </th>
                                <th>Purchase Qty</th>
                                <th>Current Qty</th>
                                <th>Use Qty</th>
                                <th>Wasted Qty</th>
                                <th>Final Qty</th>
                                <th>Unit</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
//                            echo "<pre>";
//                            print_r($get_all_used_detais);
//                            exit;
                            $i=1;
                            if(!empty($get_all_used_detais)){
                                foreach ($get_all_used_detais as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->productName."[".$row->productCode."]"; ?></td>
                                        <td><?php echo $row->previous_qty; ?></td>
                                        <td><?php echo $row->today_purchase_qty; ?></td>
                                        <td><?php echo $row->today_final_stock_qty; ?></td>
                                        <td><?php echo $row->today_use; ?></td>
                                        <td><?php echo $row->today_wasted; ?></td>
                                        <td><?php echo $row->current_qty; ?></td>
                                        <td><?php echo $row->unit_title; ?></td>
                                    <?php $i++; }
                            }
                                    ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="9" style="font-size:10px;padding-top:10px;text-align:right" >Printed by: <?php print_r($this->session->userdata('user_name')); ?> . Printed Date: <?php echo date('d-m-Y H:i:s a') ?></th>
                            </tr>
                            </tfoot>
                        </table>




                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
</section>
