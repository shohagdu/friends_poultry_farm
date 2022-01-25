<style>
    input{
        width:60px !important;
    }
</style>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title;?></h3>
                    <a href="<?php echo site_url('inventory/stockEntery'); ?>" class="btn btn-primary btn-xs pull-right" title="Add"><i class="glyphicon glyphicon-list"></i> Add New </a>
                </div>
                <div class="box-body">


                    <div class=" col-sm-12">
                        <table id="tbl1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S/L</th>
                                    <th>Log Date</th>
                                    <th>Note</th>
                                    <th>Entry By</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i=1;
                                if(!empty($get_all_used)){
                                foreach ($get_all_used as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row->log_date; ?></td>
                                        <td><?php echo $row->note; ?></td>
                                        <td><?php echo $row->username; ?></td>
                                        <td><a class="btn btn-primary btn-xs" href="<?php echo site_url('inventory/stockReportsDetails/'.md5($row->log_id)); ?>"><i class="glyphicon glyphicon-list-alt"></i> Detalis</a>
										<?php if($i==1){  ?>
										
										<a class="btn btn-info btn-xs" href="<?php echo site_url('inventory/stockReportsEdit/'.md5($row->log_id)); ?>"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
										<button class="btn btn-danger btn-xs" onclick="deleteFun('<?php echo md5($row->log_id) ?>')"><i class="glyphicon glyphicon-trash"></i>  Delete</button>
										<?php } ?>
										</td>
                                    </tr>
                                    <?php $i++; }} ?>
                            </tbody>
                            </table>



                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<script>
          function deleteFun(delete_id){   
			if (confirm('Are you sure you want to delete this?')) {
				$.ajax({
					url: "<?php echo site_url('inventory/delete_stock_data'); ?>",
					type: "POST",
					data: {
						delete_id:delete_id
					},
					success: function (data) {
						if(data=='success'){
							alert('Successfully deleted this record');
							window.location.href = "<?php echo site_url('inventory/stockReports'); ?>";
						}else{
							alert(data);
						}
						// does some stuff here...
					}
				});
			}
         }
</script>
