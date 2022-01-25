<section class="content">
    <div class="row">
        <div class="col-md-12">
           
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Expense Head</h3>

                    <?php
                        if($this->session->flashdata('msg')){
                            echo $this->session->flashdata('msg');
                        }if($this->session->flashdata('usingTransaction')){
                            echo $this->session->flashdata('usingTransaction');
                        }
                    ?>
                   <a href="<?php echo base_url('expenses/addexphead'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10%;">SL.</th>
                                <th style="width: 35%;"> Title</th>
                                <th style="width:15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($exp_head_list as $exphdeach) { ?>
                                <?php if ($exphdeach['softDelete'] == 0) { ?>
                                    <tr>
                                        <td><?php echo $sl; ?></td>
                                        <td><?php echo $exphdeach['title']; ?></td>
                                        <td>
                                            <a style="margin-right: 5px;" href="<?php echo base_url('expenses/expHeadedit'); ?>/<?php echo $exphdeach['expheadID']; ?>" class="btn btn-primary btn-sm pull-left">Edit</a>
                                            <a href="<?php echo base_url('expenses/expheaddelete'); ?>/<?php echo $exphdeach['expheadID']; ?>" onclick="return confirm('Are You Want to Delete this expense head.');" class="btn btn-danger btn-sm pull-left">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php $sl++; ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>



<script>
    function updateModal(productid){
        $('#productid').val(productid);
        $.ajax({
            url:"<?php echo site_url('products/viewProductInfo'); ?>",
            data:{sendId:productid},
            type:"POST",
            success:function(hr){
                $("#showData").html(hr);	
                        

            }
        });
    }
</script>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Products Quantity Details</h4>
            </div>
            <div class="modal-body">
                <div id="showData">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
