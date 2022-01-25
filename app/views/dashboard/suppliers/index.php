
<section class="content">
<div class="row">
	<div class="col-md-12">
		<div class="box">
            <div class="box-header">
              <h3 class="box-title">Suppliers</h3>
      				<?php
                        if($this->session->flashdata('msg')){
                            echo $this->session->flashdata('msg');
                        }if($this->session->flashdata('usingPurchase')){
                            echo $this->session->flashdata('usingPurchase');
                        }if($this->session->flashdata('usingTransaction')){
                            echo $this->session->flashdata('usingTransaction');
                        }
      				?>
                <a href="<?php echo site_url('suppliers/create'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th style="width:5%;">SL.</th>
                  <th style="width:20%">Name</th>
                  <th>Email</th>
                  <th>Phone Number</th>
                  <th>Address</th>
                  <th style="width:15%;"></th>
                </tr>
                </thead>
                <tbody>
                <?php $sl =1;?>
                <?php foreach($suppliers as $supplier){?>
                <tr>
                  <td><?php echo $sl; ?></td>
                  <td><?php echo $supplier->supplierName; ?></td>
                  <td><?php echo $supplier->supplierEmail; ?></td>
                  <td><?php echo $supplier->supplierPhone; ?></td>
                  <td><?php echo $supplier->supplierAddress; ?></td>
                  <td><a href="<?php echo base_url('suppliers/edit'); ?>/<?php echo $supplier->supplierID; ?>" class="btn btn-primary btn-sm">Edit</a> <a href="<?php echo base_url('suppliers/destroy'); ?>/<?php echo $supplier->supplierID; ?>" onclick="return confirm('Are You sure, Your want to delete This!')" class="btn btn-danger btn-sm">Delete</a></td>
                </tr>
                <?php $sl++;?>
                <?php } ?>
                </tbody>
                <tfoot>
                
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
	</div>
	<div class="col-md-1"></div>
</div>
</section>
<!-- /.content -->