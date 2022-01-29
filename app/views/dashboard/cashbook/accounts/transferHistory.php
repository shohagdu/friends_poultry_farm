<section class="content">
<div class="row">
      <div class="col-md-12">
          <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span    id="show_message"></span></div></div>
            <div class="box">
                <div class="box-header with-border">
                    <div>
                        <h3 class="box-title">Transfer History</h3>
                        <a href="<?php echo site_url('cashbook/transferadd'); ?>" class="btn btn-primary btn-sm
                        pull-right"> <i class="glyphicon glyphicon-plus"></i> Add
                            Transfer</a>

                    </div>
                </div>
                <div class="box-body">
                    <table id='transferHitoryTBL' class='display dataTable table table-bordered table-hover' >
                        <thead>
                            <tr>
                                <th>SL.</th>
                                <th>Date</th>
                                <th>From Accounts</th>
                                <th>To Accounts</th>
                                <th>Transfer Amount</th>
                                <th>Note</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->