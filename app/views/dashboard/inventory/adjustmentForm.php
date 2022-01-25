
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Adjustment </h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                    <a href="<?php echo site_url('inventory/index'); ?>" class="btn btn-primary btn-xs pull-right" title="Add"><i class="glyphicon glyphicon-list"></i> View</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-offset-2 col-sm-8">
                    <form action="<?php echo base_url('inventory/adjustmentUpdate'); ?>" method="post">
                        <div class="form-group">
                            <label>Warehouse</label>
                            <select name="warehouseID" class="form-control" style="width: 100%;">

                                <?php foreach ($warehouses as $warehouse) { ?>
                                    <?php
                                            if($warehouse->warehouseID==4){
                                                $selected=($warehouse->warehouseID==4) ? "Selected":'';
                                        ?>
                                    <option value="<?php echo $warehouse->warehouseID; ?>" <?php echo $selected; ?>><?php echo $warehouse->warehouseName; ?></option>

                                <?php } } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Product Name</label>
                            <select name="productID" required class="form-control select2" style="width: 100%;">
                                <option value="">Select Product</option>
                                <?php foreach ($products as $product) { ?>
                                    <option value="<?php echo $product->productID; ?>"><?php echo $product->productName." (".$product->productCode.")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Adjustment Type</label>
                            <select name="type" required class="form-control select2" style="width: 100%;">
                                <option value="">Adjustment Type</option>
                                <option value="DAMAGE-OUT">Damage</option>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Quantity</label>
                            <input required="" autocomplete="off" name="quantity" class="form-control" placeholder="Quantity">
                        </div>



                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>

                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
