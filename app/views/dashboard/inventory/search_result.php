<section class="content">
    <section class="invoice">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <a href="<?php echo base_url('inventory/index')?>" class="btn btn-default btn-xs pull-right">
                        <span class="glyphicon glyphicon-step-backward"></span>Back
                    </a>
                </div>
            </div>
            <div class="col-xs-12">
                <h2 class="page-header">
                    Inventory
                    <small class="pull-right">Date: 2/10/2014</small>
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Store</th>
                            <th style="width: 20%;">Product Category</th>
                            <th style="width: 70%;">Product Name ( Barcode )</th>
                            <th style="width: 10%;">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventroyseracrdatabyhouse as $value) { ?>
                            <tr>
                                <td>
                                    <?php
                                    $whouse_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_warehouses', 'warehouseID', $value['warehouseID']);
                                    echo $whouse_name['warehouseName'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $prodt_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_products', 'productID', $value['productID']);
                                    $id = $prodt_name['catagoryID'];
                                    $prodt_names = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_product_catagories', 'product_catagoriesID', $id);
                                    echo $prodt_names['catagoryName'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $prodt_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_products', 'productID', $value['productID']);
                                    echo $prodt_name['productName'].'('. $prodt_name['productCode'].')';
                                    ?>
                                </td>
                                <td><b><?php echo $value['ttlbalance']; ?></b></td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</section>