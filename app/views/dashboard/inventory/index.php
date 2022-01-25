
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Inventory</h3>
                    <a href="<?php echo site_url('inventory/adjustment'); ?>" class="btn btn-primary btn-xs pull-right" title="Add"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <div class="box-body">
                    <form action="<?php echo base_url('inventory/serarchInventroy'); ?>" method="post">
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">
                                    <?php
                                    $this->db->select('*');
                                    $this->db->from('tbl_pos_warehouses');
                                    $this->db->order_by("warehouseID", "desc");
                                    $this->db->where("warehouseID", 4);
                                    $query = $this->db->get();
                                    $result = $query->result_array();
                                    //                        dumpVar($result);
                                    ?>
                                    <select name="warehouseID" class="form-control select2" style="width: 100%;">
                                        <?php foreach ($result as $warehouse) { ?>
                                            <option value="<?php echo $warehouse['warehouseID']; ?>"><?php echo $warehouse['warehouseName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group ">
                                    <?php
                                    $this->db->select('*');
                                    $this->db->from('tbl_pos_products');
                                    $query = $this->db->get();
                                    $results = $query->result_array();
                                    //                        dumpVar($results);
                                    ?>
                                    <select name="productID" class="form-control select2" style="width: 100%;">
                                        <option value="">Products</option>
                                        <?php foreach ($results as $e_product) { ?>
                                            <option value="<?php echo $e_product['productID']; ?>"><?php echo $e_product['productName'].'('.$e_product['productCode'].')'; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            Inventory
                            <small class="pull-right">Date: <?php echo $today = date("d-m-Y");?></small>
                        </h2>
                    </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-xs-12 table-responsive">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 20%;">Product Category</th>
                                    <th style="width: 70%;">Product Name ( Barcode )</th>
                                    <th style="width: 10%;">Qty</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($inventory as $value) { ?>
                                    <tr>
                                        <td><?php echo $value->catagoryName; ?></td>
                                        <td><?php echo $value->productName.'('.$value->productCode.')'; ?></td>
                                        <td><b><?php echo $value->ttlqty; ?></b></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>

