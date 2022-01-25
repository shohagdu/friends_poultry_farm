<!-- Content Header (Page header) -->
<section class="content-header">
  
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Edit Supplier</h3>
		          	<?php if($this->session->flashdata('msg')){?>
    
				        <?php echo $this->session->flashdata('msg'); ?>
				    
				    <?php }?>
		        </div>
		        <div class="box-body">
		          <form action="<?php echo base_url('suppliers/update'); ?>" method="post">
				      <input type="hidden" name="supplierID" value="<?php echo $suppliers[0]->supplierID; ?>">
				      <input type="hidden" name="original-supplierName" value="<?php echo $suppliers[0]->supplierName; ?>">
				      <input type="hidden" name="original-supplierEmail" value="<?php echo $suppliers[0]->supplierEmail; ?>">
				      <input type="hidden" name="original-supplierPhone" value="<?php echo $suppliers[0]->supplierPhone; ?>">
				      <div class="form-group has-feedback">
				      	<label>Supplier Name</label>
				        <input name="supplierName" class="form-control" placeholder="Supplier Name" value="<?php echo $suppliers[0]->supplierName; ?>">
				      </div>
				      <div class="form-group has-feedback">
				      	<label>Supplier Email</label>
				        <input type="email" name="supplierEmail" class="form-control" placeholder="Supplier Email" value="<?php echo $suppliers[0]->supplierEmail; ?>">
				      </div>
				      <div class="form-group has-feedback">
				        <label>Supplier Phone Number</label>
				        <input name="supplierPhone" class="form-control" placeholder="Supplier Phone Number" value="<?php echo $suppliers[0]->supplierPhone; ?>">
				      </div>
				      <div class="form-group has-feedback">
				      	<label>Supplier Address</label>
				        <textarea class="textarea" name="supplierAddress"  placeholder="Supplier Address" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $suppliers[0]->supplierAddress; ?></textarea>
				      </div>
				      
				      <div class="row">
				        <div class="col-xs-4">
				          
				        </div>
				        <div class="col-xs-4">
				          
				        </div>
				        <!-- /.col -->
				        <div class="col-xs-4">
				          <button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
				        </div>

				        <!-- /.col -->
				      </div>
				    </form>
		        </div>
		        <!-- /.box-body -->
		    </div>
		</div>
		<div class="col-md-3"></div>
	</div>
</section>
<!-- /.content -->