<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                            id="show_message"></span></div></div>
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?> Information</h3>
                    <a href="<?php echo base_url('settings/outlet_info') ?>" class="btn btn-warning pull-right"  ><i
                                class="glyphicon
                    glyphicon-backward"></i> Back </a>
                </div>
                <div class="box-body">
                    <table class="table-style" style="width: 60%;margin-bottom: 10px;">
                        <tr>
                            <th class="text-left" style="width: 15%;">Outlet Name</th>
                            <td  class="text-left" style="width: 35%;"><?php echo (!empty($outlet_info->name)?$outlet_info->name:'');
                            ?></td>
                            <th  class="text-left" style="width: 15%;">Mobile</th>
                            <td  class="text-left" style="width: 35%;"><?php  echo (!empty($outlet_info->mobile)
                                    ?$outlet_info->mobile:''); ?></td>
                        </tr>
                        <tr>
                            <th  class="text-left">Email</th>
                            <td  class="text-left"><?php  echo (!empty($outlet_info->email)?$outlet_info->email:'');
                            ?></td>
                            <th  class="text-left">Address</th>
                            <td  class="text-left"><?php  echo (!empty($outlet_info->address)?$outlet_info->address:'');
                                ?></td>
                        </tr>
                    </table>
                    <form action="" method="post" id="outletOpeningStockForm" class="form-horizontal"
                          enctype="multipart/form-data">
                        <table  class='table  table-hover table-style' style="border: 1px solid #d0d0d0;"   >
                            <thead>
                            <tr>
                                <td class="font-weight-bold" style="width:5%;">SL.</td>
                                <td class="font-weight-bold text-left" style="width:30%;">Product Name</td>
                                <td  class="font-weight-bold text-left" style="width:10%;">Brand</td>
                                <td class="font-weight-bold" style="width:10%;">Source</td>
                                <td class="font-weight-bold" style="width:10%;">Type</td>
                                <td class="font-weight-bold" style="width:20%;">Opening Stock Item</td>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=1;
                                    if(!empty($product_info)){
                                        foreach($product_info as $product){
                                ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td class="text-left"><?php echo (!empty($product->name)?$product->name:''); echo
                                                (!empty
                                                ($product->productCode)?"(".$product->productCode.")":''); ?>
                                            <input type="hidden" name="product_id[<?php echo (!empty($product->id)
                                                ?$product->id:'')
                                            ?>]" class="form-control" value="<?php echo (!empty($product->id)?$product->id:'') ?>"
                                                       id="product_id_1">
                                            </td>
                                            <td class="text-left"><?php echo (!empty($product->bandTitle)?$product->bandTitle:'');
                                            ?></td>
                                            <td><?php echo (!empty($product->sourceTitle)?$product->sourceTitle:''); ?></td>
                                            <td><?php echo (!empty($product->ProductTypeTitle)?$product->ProductTypeTitle:''); ?></td>
                                            <td><input type="text" name="item_count[<?php echo (!empty($product->id)?$product->id:'')
                                                ?>]" class="form-control"  value="<?php echo $product->opening_stock_qty ?>" placeholder="Enter Opening Stock Item" id="item_count_<?php echo (!empty($product->id)?$product->id:'') ?>"></td>
                                        </tr>
                                <?php
                                        }
                                    ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="4" class="text-right">
                                        <input type="hidden" name="outlet_id" value="<?php echo !empty($this->uri->segment
                                        ('3'))?$this->uri->segment('3'):'' ?>">
                                        <button type="button" class="btn btn-success submit_btn" onclick="saveOpeningStockInfo()
"><i class="glyphicon glyphicon-ok-sign"></i> Update Opening Stock</button>
                                    </td>
                                </tr>
                                    <?php
                                    }
                                ?>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
</section>


