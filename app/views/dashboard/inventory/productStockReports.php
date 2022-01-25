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
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box no-border">
                <div class="box-header with-border">
                    <div class="col-sm-4"> <h3 class="box-title"><?php echo $title;?></h3></div>
                    <div class="col-sm-8 no-print">

                        <a href="<?php echo site_url('inventory/stockReports'); ?>" class="btn btn-primary btn-xs pull-right" title="Stock Report "><i class="glyphicon glyphicon-backward"></i> Stock Report </a>
                        <a href="<?php echo site_url('inventory/productStockReports'); ?>" class="btn btn-warning btn-xs pull-right" title="Refresh "  style="margin-right:10px;"><i class="glyphicon glyphicon-refresh"></i> Refresh </a>
                        <button class="btn btn-info btn-xs pull-right" style="margin-right:10px;" onclick="window.print();"><i class="glyphicon glyphicon-print"></i> Print</button>
                    </div>
                </div>
                <div class="box-body">
                    <div class=" col-sm-12">
                        <div class="row">
                        <form action="<?php echo site_url('inventory/productStockReports'); ?>" method="post" role="form">
                            <div class="col-sm-12 no-print">
                                <div class="col-sm-4 col-lg-4" style="margin-bottom: 10px;">
                                    <label>Search Product</label>
                                    <input type="text" id="productName" required data-type="productName" placeholder="Search Product code"  class="productName form-control" style="width:100% !important;">
                                    <input type="hidden" required name="productID" id="productID" class="form-control" style="width:100% !important;">
                                </div>
                                <div class=" col-xs-5">
                                    <label>Date Range</label>
                                    <input name="search_date" value="<?php echo date('Y-m-d') ?>" id="reservation" class="form-control" placeholder="YYYY-MM-DD" style="width:100% !important;">
                                </div>
                                <div class="col-xs-2">
                                    <div class="col-sm-12"
                                    <label >.</label>
                                    <button type="submit" name="searchBtn" class="btn btn-success pull-right"><i class="glyphicon glyphicon-search"></i> Search </button>
                                </div>
                            </div>
                        </form>
                        </div>
                    <?php
                    if(isset($_POST['searchBtn'])){
                    ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <?php
                            if(!empty($getDateWiseProduct)){
                            ?>
                            <tr>
                                <td colspan="4"><b>Product Name:</b> <?php echo  $getDateWiseProduct[0]->productName." [".$getDateWiseProduct[0]->productCode."]"; ?></td>
                                <td colspan="4"><b>Date Range:</b> <?php echo $date_range; ?></td>

                            </tr>
                            <?php  }?>
                            <tr>
                                <th style="width:5%">S/L</th>
                                <th  style="width:10%">Date</th>
                                <th style="width:10%">Previous Qty</th>
                                <th style="width:10%">Purchase Qty</th>
                                <th style="width:10%">Final Qty</th>
                                <th style="width:10%">Use Qty</th>
                                <th style="width:10%">Current Qty</th>
                                <th style="width:10%">Product Unit</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?php
                            $i=1;
                            if(!empty($getDateWiseProduct)){
                            foreach ($getDateWiseProduct as $row){
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row->use_date; ?></td>
                                <td><?php echo $row->previous_qty; ?></td>
                                <td><?php echo $row->today_purchase_qty; ?></td>
                                <td><?php echo $row->today_final_stock_qty; ?></td>
                                <td><?php echo $row->today_use; ?></td>
                                <td><?php echo $row->current_qty; ?></td>
                                <td><?php echo $row->unit_title; ?></td>
                                <?php $i++; }
                                }
                                ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="8" style="font-size:10px;padding-top:10px;text-align:right" >Printed by: <?php print_r($this->session->userdata('user_name')); ?> . Printed Date: <?php echo date('d-m-Y H:i:s a') ?></th>
                            </tr>
                            </tfoot>
                        </table>
                        <?php  } ?>
                    </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
</section>
<script>
    $(".productName").autocomplete({
        source: "<?php echo site_url('Purchases/productNameSuggestions'); ?>",
        select: function (event, ui) {
            $("#productName").val(ui.item.value);
            $("#productID").val(ui.item.id);
            return false;
        }
    });
</script>
