<section class="content-header">
</section>
<section class="content">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Product</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <div class="box-body">
                    <form action="" method="post">
                        <input type="hidden" name="head_id"  value="<?php // echo $products['productID']; ?>">
                       <div class="form-group">
                            <?php
                            $this->db->select('*');
                            $this->db->from('tbl_pos_expense_head');
                            $query = $this->db->get();
                            $result = $query->result_array();
                            ?>
                            <label>Expense Head</label>
                            <select name="head_id" class="form-control select2" style="width: 100%;">
                              
                                <?php foreach ($result as $eachhead) { ?>
                                    <option <?php
                                if ($expsubhead['head_id'] == $eachhead['expheadID']) {
                                    echo "selected";
                                }
                                    ?> value="<?php echo $eachhead['expheadID']; ?>"><?php echo $eachhead['title']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Title</label>
                            
                            <input required="" name="title" class="form-control" placeholder="Product Name" value="<?php echo $expsubhead['title']; ?>">
                        </div>
                        <div class="row">
                            <div class="col-xs-4">

                            </div>
                            <div class="col-xs-4">

                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                            </div>

                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-4"></div>
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