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
		          <h3 class="box-title">Edit Account</h3>
		          	<?php if($this->session->flashdata('msg')){?>
    
				        <?php echo $this->session->flashdata('msg'); ?>
				    
				    <?php }?>
		        </div>
		        <div class="box-body">
		          <form action="<?php echo base_url('cashbook/Accountupdate'); ?>" method="post">
				      <input value="<?php echo $accounts[0]->accountID; ?>" name="accountID" type="hidden">
				      <input value="<?php echo $accounts[0]->accountName; ?>" name="original-accountName" type="hidden">
				      <div class="form-group has-feedback">
				      	<label>Account Name</label>
				        <input value="<?php echo $accounts[0]->accountName; ?>" name="accountName" class="form-control" placeholder="Account Name">
				      </div>
				      <div class="form-group has-feedback">
				      	<label>Account Type</label>
				        <select id="accountType" name="accountType" class="form-control select2" style="width: 100%;">
				        <?php if($accounts[0]->accountType == 'BANK'){?>
                          	<option value="BANK">Bank</option>
                          	<option value="CASH">Cash</option>                          	
                        <?php }else{ ?>
                        	<option value="CASH">Cash</option>
                          	<option value="BANK">Bank</option>
                        <?php } ?>
                        </select>
				      </div>
				      <?php if($accounts[0]->accountType == 'BANK'){
				      		$display = 'display: block;';
				      	}else{
				      		$display = 'display: none;';
				      		}?>
				      <div style="<?php echo $display; ?>" class="accountNumber form-group has-feedback">
				        <label>Account Number</label>
				        <input value="<?php echo $accounts[0]->accountNumber; ?>" name="accountNumber" class="form-control" placeholder="Account Number">
				      </div>
				      <div style="<?php echo $display; ?>" class="branchName form-group has-feedback">
				        <label>Branch Name</label>
				        <input value="<?php echo $accounts[0]->accountBranchName; ?>" name="accountBranchName" class="form-control" placeholder="Branch Name">
				      </div>
				      <div class="form-group has-feedback">
				      	<label>Note</label>
				        <textarea class="textarea" name="note"  placeholder="Note" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $accounts[0]->note; ?></textarea>
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

<script type="text/javascript">
	$(function() {
	    $('#accountType').change(function(){
	    	var accountType = $('#accountType').val();
	    	if(accountType == 'BANK'){
	    		$('.accountNumber').fadeIn();
	    		$('.branchName').fadeIn();
	    	}else{
	    		$('.accountNumber').fadeOut();
	    		$('.branchName').fadeOut();
	    	}
	    });
	});
</script>