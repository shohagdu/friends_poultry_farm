

<!-- Main content -->
<section class="content">

<!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          Balance Statement
          <small class="pull-right" id="today"></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->

    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Sl.</th>
            <th>Account Name</th>
            <th>Account Number</th>
            <th>Branch Name</th>
            <th>Balance</th>
          </tr>
          </thead>
          <tbody>
          	<?php $balance = 0;?>
          	<?php $sl = 1;?>
          	<?php foreach($accountBalanceHistory as $accountBalance){?>
          	<?php $balance = $accountBalance->balance + $balance;?>
          		<tr>
          			<td><?php echo $sl;?></td>
          			<td><?php echo $accountBalance->accountName; ?></td>
          			<td><?php echo $accountBalance->accountNumber; ?></td>
          			<td><?php echo $accountBalance->accountBranchName; ?></td>
          			<td><?php echo ($accountBalance->balance=='') ? '0.00':$accountBalance->balance; ?></td>
          		</tr>
          		<?php $sl++;?>
          	<?php } ?>
          	<tr>
      			<td></td>
      			<td></td>
      			<td></td>
      			<th>Total Balance</th>
      			<th><?php echo $balance; ?></th>
      		</tr>
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      	<div class="col-xs-2">
			<button type="button" onclick="window.print();" class="no-print btn btn-block btn-success btn-flat"><i class="fa fa-print"></i>  Print</button>
		</div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

</section>
<!-- /.content -->


<script type="text/javascript">
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();

	if(dd<10) {
	    dd='0'+dd
	}

	if(mm<10) {
	    mm='0'+mm
	}

	today = yyyy+'/'+mm+'/'+dd;
	//document.write(today);
	$('#today').text(today);
</script>