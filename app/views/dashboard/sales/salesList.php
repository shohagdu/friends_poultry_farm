<section class="content">
    <div class="box">
        <div class="box-header">
            <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                            id="show_message"></span></div></div>
            <h3 class="box-title">Sales Record</h3>
            <a href="<?php echo site_url('pos/salesList'); ?>" style="margin-left:10px"  class="btn btn-primary btn-sm  pull-right"><i
                        class="glyphicon glyphicon-refresh"></i> Refresh</a>
            <a href="<?php echo site_url('pos/index'); ?>"  class="btn btn-info pull-right btn-sm"
               ><i
                        class="glyphicon glyphicon-plus"></i> Sales Point</a>

        </div>
        <div class="box-body">
            <div class="row" style="margin-bottom:5px;">
                <form action="" method="post">
                    <div class="col-sm-4 col-xs-8 clearfix">
                        <input type="text" id="customerName_11" class="customerName form-control"
                               placeholder="Searching by Customer Name Or Mobile "  >

                        <input type="hidden" name="customer_id" id="customerID_11" class="  form-control"  >
                    </div>
                    <div class="col-sm-2 col-xs-4 clearfix">
                        <input type="text" name="salesID" id="salesID" placeholder="Invoice No"
                                   class="form-control pull-right invoiceNumber">
                    </div>
                    <!--
                    <div class="col-sm-4">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="date" value="<?php echo date('Y/m/01 - Y/m/d') ?>"  class="form-control pull-right" id="reservation">
                        </div>
                    </div>
                    -->


                </form>
            </div>
            <div class="clearfix"></div>
            <div class="table-responsive" >
            <table id='SalesInfo' class='display dataTable table table-bordered table-hover' >
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Invoice No</th>
                        <th>Customer Info</th>
                        <th>Sales Date</th>
                        <th>Net Total</th>
                        <th style="width:100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>

            </table>
            </div>
        </div>
    </div>
</section>

<script>
    //$("#tags_11").autocomplete({
    //    source: '<?php //echo site_url('pos/getcustomername'); ?>//',
    //    select: function (event, ui) {
    //        $("#tags_11").val(ui.item.value);
    //        $("#cst_id").val(ui.item.id);
    //        return false;
    //    }
    //});
    //$("#saleNo").autocomplete({
    //    source: '<?php //echo site_url('pos/viewInvoiceNo'); ?>//',
    //    select: function (event, ui) {
    //        $("#saleNo").val(ui.item.value);
    //        $("#salesID").val(ui.item.id);
    //        return false;
    //    }
    //});

</script>
