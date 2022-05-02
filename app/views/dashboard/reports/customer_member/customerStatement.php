<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">  <?php echo !empty($title)?$title:'' ?></h3>
                    <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i
                            class="glyphicon glyphicon-print"></i> Print</button>
                </div>
                <div class="clearfix"></div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table  class='table table-bordered table-hover' >
                            <thead>
                                <tr>
                                    <th style="width:5%;">SL.</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Current Due Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=1;
                                    $tCurrentDueAmt='0.00';
                                    if(!empty($info)){
                                        foreach ($info as $row){
                                ?>
                                    <tr>
                                        <td><?php echo $i++ ?></td>
                                        <td><?php echo (!empty($row->name)?$row->name:'') ?></td>
                                        <td><?php echo (!empty($row->mobile)?$row->mobile:'') ?></td>
                                        <td><?php echo (!empty($row->address)?$row->address:'') ?></td>
                                         <td><?php echo (!empty($row->is_active)?(($row->is_active==1)
                                                 ?"Active":"Inactive"):'')
                                             ?></td>

                                        <td style="text-align: right;font-weight: bold; color: <?php echo (
                                                ($row->current_due>0)
                                            ?'red':'green')
                                        ?>"><?php
                                            echo
                                            (!empty
                                            ($row->current_due)
                                                ?$row->current_due:'');
                                            $tCurrentDueAmt+=$row->current_due;
                                        ?></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align: right">
                                        Total Amount
                                    </th>
                                    <td style="text-align: right;font-weight: bold; color: <?php echo (
                                    ($tCurrentDueAmt>0)
                                        ?'red':'green')
                                    ?>"><?php echo number_format($tCurrentDueAmt,2); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
