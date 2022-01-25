<section class="content">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">New Product</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <div class="box-body">
                    <form action="" method="post">
                        
                        <div class="form-group has-feedback">
                            <label>Expense Title</label>
                            <input  name="title" class="form-control" value="<?php echo $exphead['title']?>" placeholder="Expense Title" required>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">

                            </div>
                            <div class="col-xs-4">

                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">update</button>
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