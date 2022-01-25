<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Expense Head</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                    <a href="<?php echo base_url('expenses/expHeadlist'); ?>" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> view</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-8 col-sm-offset-2">
                        <form action="<?php echo base_url('expenses/addexphead'); ?>" method="post">

                            <div class="form-group has-feedback">
                                <label>Expense Title</label>
                                <input required="" name="title" class="form-control" placeholder="Expense Title"
                                       required>
                            </div>

                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
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
    var randomString = function (length) {
        var text = "";
        var possible = "0123456789";
        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    var codeLenghtCheck = function () {
        var code = $('#productCode').val();
        if (code.length < 8) {
            $("#productCodeError").text("Product Code must be minimum 8 digit lenght.");
        } else if (code.length > 8) {
            $("#productCodeError").text("Product Code must be maximum 8 digit lenght.");
        } else {
            $("#productCodeError").empty();
        }
    };

    $("#random").click(function () {
        $('#productCode').val(randomString(8));
        codeLenghtCheck();
    });

    $("#productCode").keyup(function () {
        codeLenghtCheck();
    });

    $("#productCode").change(function () {
        codeLenghtCheck();
    });

</script>