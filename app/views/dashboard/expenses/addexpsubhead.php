
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">New Sub Head</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                    <a  class="btn btn-primary pull-right btn-sm" href="<?php echo base_url('expenses/expsubheadlist'); ?>"><i class="glyphicon glyphicon-list"></i> View</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                    <form action="" method="post">
                        <div class="form-group">
                            <?php
                            $this->db->select('*');
                            $this->db->from('tbl_pos_expense_head');
                            $query = $this->db->get();
                            $result = $query->result_array();
                            ?>
                            <label>Expense Head</label>
                            <select name="head_id" class="form-control select2" style="width: 100%;">
                                <option value="">-- Expense Head --</option>
                                <?php foreach ($result as $eachhead) { ?>
                                    <option value="<?php echo $eachhead['expheadID']; ?>"><?php echo $eachhead['title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Title</label>
                            <input required="" name="title" class="form-control" placeholder="Sub Head Title">
                        </div>
                        

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-success btn-sm">Save</button>
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
    var randomString = function(length) {
        var text = "";
        var possible = "0123456789";
        for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    var codeLenghtCheck = function () {
        var code = $('#productCode').val();
        if( code.length < 8 ){
            $("#productCodeError").text("Product Code must be minimum 8 digit lenght.");
        }else if(code.length > 8){
            $("#productCodeError").text("Product Code must be maximum 8 digit lenght.");
        }else{
            $( "#productCodeError" ).empty();
        }
    };

    $( "#random" ).click(function() {
        $('#productCode').val(randomString(8));
        codeLenghtCheck();
    });

    $( "#productCode" ).keyup(function() {
        codeLenghtCheck();
    });

    $( "#productCode" ).change(function() {
        codeLenghtCheck();
    });
	
</script>