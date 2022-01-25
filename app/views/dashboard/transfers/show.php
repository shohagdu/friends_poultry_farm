<style type="text/css">
	address p {
		margin: 0px;
	}
</style>

<!-- Content Header (Page header) -->
<section class="content-header">
  
</section>

<!-- Main content -->
<section class="content">

<!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          Transfer
          <small class="pull-right" id="today"></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        From
        <address>
          <strong><?php echo $transfers[0]->fromWarehouseInfo->warehouseName; ?></strong><br>
          Phone: <?php echo $transfers[0]->fromWarehouseInfo->warehousePhone; ?><br>
          <?php echo $transfers[0]->fromWarehouseInfo->warehouseAddress; ?><br>
          
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        To
        <address>
          <strong><?php echo $transfers[0]->toWarehouseInfo->warehouseName; ?></strong><br>
          Phone: <?php echo $transfers[0]->toWarehouseInfo->warehousePhone; ?><br>
          <?php echo $transfers[0]->toWarehouseInfo->warehouseAddress; ?><br>
          
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        <b>Transfer No <?php echo $transfers[0]->transferNo; ?></b><br>
        <br>
        <b>Transfer Date:</b> <?php echo $transfers[0]->transferDate; ?>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Qty</th>
            <th>Product</th>
            <th>Product Catagory</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($transfers[0]->products as $product) { ?>
          <tr>
            <td><?php echo $product->quantity ; ?></td>
            <td><?php echo $product->productName ; ?> (<?php echo $product->productCode ; ?>)</td>
            <td><?php echo $product->catagoryName ; ?></td>
          </tr>	
          <?php } ?>
          
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-xs-6">
        
        
          <b>Note:</b> <?php echo $transfers[0]->note; ?>
        
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        
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