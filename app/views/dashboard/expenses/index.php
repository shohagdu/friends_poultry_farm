<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span    id="show_message"></span></div></div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $title; ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                    <a href="<?php echo site_url('expenses/create'); ?>" class="btn btn-primary btn-sm pull-right"><i
                                class="glyphicon glyphicon-plus"></i> Add New</a>
                </div>
                <div class="box-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3 col-xs-8 clearfix">
                                <select id="expenseCtg" class=" form-control" >
                                    <option value="">Select Expense Category</option>
                                    <?php
                                        if(!empty($expensehead)){
                                            foreach ($expensehead as $expHead){
                                                echo '<option value="'.$expHead->id.'">'.$expHead->title.'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <table id="expenseInfoTBL" class='display dataTable table table-bordered table-hover' >
                        <thead>
                            <tr>
                                <th style="width: 5%;">S/N</th>
                                <th style="width: 15%;">Date</th>
                                <th style="width: 20%;">Expense Category</th>
                                <th style="width: 15%;">Account Info</th>
                                <th style="width: 10%;">Exp. Account</th>
                                <th style="width: 10%;">Remarks</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function updateModal(productid) {
        $('#productid').val(productid);
        $.ajax({
            url: "<?php echo site_url('products/viewProductInfo'); ?>",
            data: {sendId: productid},
            type: "POST",
            success: function (hr) {
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
