<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                    <a href="<?php echo site_url('expenses/create'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <div class="box-body">
                    <table id="tbl1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%;">SL.</th>
                                <th style="width: 20%;">Expense Head</th>
                                <th style="width: 15%;">Sub Head</th>
                                <th style="width: 25%;">Account</th>
                                <th style="width: 5%;">Amount</th>
                                <th style="width: 15%;">Date</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($expenselist as $expense) { ?>

                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td>
                                        <?php
                                        $head_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_expense_head', 'expheadID', $expense['head_id']);
                                        echo $head_name['title'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $subhead_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_exp_sub_head', 'subheadid', $expense['sub_head_id']);
                                        echo $subhead_name['title'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $accnt_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_accounts', 'accountID', $expense['account_id']);
                                        echo $accnt_name['accountName'];
                                        ?>
                                    </td>
                                    <td><?php echo $expense['amount']; ?></td>
                                      <td><?php echo date('Y-m-d',strtotime($expense['created_at'])); ?></td>
                                    <td>
                                        <a style="margin-right: 5px;" href="<?php echo base_url('expenses/edit'); ?>/<?php echo $expense['expenseID']; ?>" class="btn btn-primary btn-sm pull-left">Edit</a>
                                        <a href="<?php echo base_url('expenses/delete'); ?>/<?php echo $expense['expenseID']; ?>" onclick="return confirm('Are You sure, Your want to delete This!')" class="btn btn-danger btn-sm pull-left">Delete</a></td>
                                </tr>


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
