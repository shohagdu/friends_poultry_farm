<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">New Supplier</h3>
		          	<?php if($this->session->flashdata('msg')){?>
    
				        <?php echo $this->session->flashdata('msg'); ?>
				    
				    <?php }?>
                    <a href="<?php echo site_url('suppliers/index'); ?>"
                       class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> View</a>
		        </div>
		        <div class="box-body">
                    <div class="col-sm-offset-1 col-sm-10">
		          <form action="<?php echo base_url('suppliers/store'); ?>" method="post">
				      <div class="form-group has-feedback">
				      	<label>Supplier Name</label>
				        <input name="supplierName" class="form-control" placeholder="Supplier Name">
				      </div>
				      <div class="form-group has-feedback">
				      	<label>Supplier Email</label>
				        <input type="email" name="supplierEmail" class="form-control" placeholder="Supplier Email">
				      </div>
				      <div class="form-group has-feedback">
				        <label>Supplier Phone Number</label>
				        <input name="supplierPhone" class="form-control" placeholder="Supplier Phone Number">
				      </div>
				      <div class="form-group has-feedback">
				      	<label>Supplier Address</label>
				        <textarea class="textarea" name="supplierAddress"  placeholder="Supplier Address" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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