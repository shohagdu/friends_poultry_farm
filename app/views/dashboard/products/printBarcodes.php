<!-- Main content -->
<section >
	<div class="row no-print">
		<div class="col-md-12">
			<div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Print Barcode/Label</h3>
		          	<?php if($this->session->flashdata('msg')){?>

				        <?php echo $this->session->flashdata('msg'); ?>

				    <?php }?>
		        </div>
		        <div class="box-body">
		          	<div class="row">
		          		<div class="col-md-12">
		          			<div class="form-group has-feedback">
						        <label>Add Product</label>
						        <input id="productName" class="form-control" placeholder="Add Product">
						    </div>
		          		</div>
		          	</div>
		          	<form action="<?php echo base_url('products/printBarcodes'); ?>" method="post">
		          	<div class="row">
		          		<div class="col-md-12">
		          			<table id="tableStyle" class="table table-bordered" >
				                <thead>
				                <tr>
				                  <th>Product Name (Product Code)</th>
				                  <th style="width: 8%;">Quantity</th>
				                  <th style="width: 20%;">Product Catagory</th>
				                  <th style="width:10%;">Action</th>
				                </tr>
					            </thead>
					            <tbody id="tableDynamic">

					            </tbody>
				            </table>
		          		</div>
		          	</div>
		          	<div class="row">
		          		<div class="col-md-12 text-center">
		          			<button type="submit" class="btn  btn-primary btn-lg"><i class="glyphicon glyphicon-ok-sign"></i> Generate Barcode</button>
		          			<a href="<?php echo base_url(); ?>products/printBarcodes" class="btn btn-danger btn-lg"><i class="glyphicon glyphicon-refresh"></i> Clear</a>
		          		</div>

		          	</div>
		          	</form>
				</div>
		        <!-- /.box-body -->
		    </div>
		</div>
		<div class="col-md-1"></div>
	</div>
	<?php if(isset($barcodes)){ ?>
         <div class="col-sm-offset-10 col-sm-2 no-print">
            <button type="button" onclick="window.print();"  class="no-print btn btn-block btn-success btn-lg btn-flat print-button"><i class="fa fa-print"></i> </button>
         </div>
        <div class="clearfix"></div>
        <div class="col-sm-offset-5 "  style="margin-top: 0px;">
            <?php  foreach($barcodes as $barcode){   ?>
            <?php for($i = 0 ; $i < $barcode['productQuantity']; $i++){?>
                <div class="dashboard-section" >
                    <div class="barcode-label-container" >
                        <div id="barcode-label" class="barcode-label">
                            <div class="barcode-text">
                                <div >RED GREEN</div>
                                <span class="barcode-strong"><?php echo $barcode['productName']; ?></span>
                            </div>
                            <div class="barcode-area">
                                <img src="<?php echo base_url('Products/genBarcode/'.$barcode['productCode']); ?>" alt="<?php echo $barcode['productCode']; ?>">
                            </div>
                            <div class="barcode-foot barcode-strong barcode-rotated">
                                MRP-<?php echo $barcode['productPrice']; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div style="white-space: pre-line"></div>
            <?php } ?>

            <?php } ?>
        </div>
        <div class="clearfix"></div>
	<?php } ?>
</section>
<!-- /.content -->
