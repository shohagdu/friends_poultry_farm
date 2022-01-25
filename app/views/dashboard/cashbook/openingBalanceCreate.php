<!-- Main content -->
<section class="content">
	<div class="row">

		<div class="col-md-12">
			<div class="box">
		        <div class="box-header with-border">
		          <h3 class="box-title">Opening Balance</h3>
		          	<?php if($this->session->flashdata('msg')){?>
    
				        <?php echo $this->session->flashdata('msg'); ?>
				    
				    <?php }?>
		        </div>
		        <div class="box-body">
                    <div class="col-sm-offset-1 col-sm-10">
		          <form action="<?php echo base_url('cashbook/OpeningBalanceStore'); ?>" method="post">
				      <div class="form-group">
		                <label>Account</label>
		                <select name="transactionAccountID" class="form-control select2" style="width: 100%;">
		                  <option value="">Select Account</option>
		                  <?php foreach($accounts as $account){?>
		                  
		                  	<option value="<?php echo $account->accountID; ?>"><?php echo $account->accountName; ?>  <?php echo $account->accountNumber; ?></option>
		                  
		                  <?php } ?>
		                </select>
		              </div>
				      <div class="form-group has-feedback">
				        <label>Opening Balance</label>
				        <input name="transactionAmount" class="form-control" placeholder="Opening Balance">
				      </div>
				      
				      <div class="form-group has-feedback">
				      	<label>Note</label>
				        <textarea class="textarea" name="transactionNote"  placeholder="Note" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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

<script type="text/javascript">
	
	
</script>