<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <button class="btn btn-primary btn-sm pull-right no-print" onclick="window.print()"><i class="glyphicon glyphicon-print"></i> Print</button>
                </div>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table   class=' table-style' style="width:100%;border:1px solid #d0d0d0;"  >
                        <thead>
                        <tr>
                            <td class="font-weight-bold"  style="width:5%;">SL.</td>
                            <td class="font-weight-bold" >Name</td>
                            <td class="font-weight-bold">Mobile</td>
                            <td class="font-weight-bold">Email</td>
                            <td class="font-weight-bold">Current Stock</td>
                            <td class="font-weight-bold">Current Due Amount</td>
                            <td class="no-print font-weight-bold" style="width:15%;">Action</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $tDue='0.00';
                         if(!empty($info)){
                             foreach ($info as $row){
                                 ?>
                                 <tr>
                                     <td><?php echo $row->serial_no ?></td>
                                     <td class="text-left"><?php echo $row->name ?></td>
                                     <td class="text-left"><?php echo $row->mobile ?></td>
                                     <td class="text-left"><?php echo $row->address ?></td>
                                     <td><?php echo $row->current_stock ?></td>
                                     <td><?php echo $row->current_due;  $tDue+=number_format($row->current_due_amt,2,'.','');
                                     ?></td>
                                     <td class="no-print"><?php echo $row->action ?></td>
                                 </tr>
                        <?php
                             }
                         }
                        ?>


                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">Total Due Amount</td>
                                <td > <span class="badge bg-green"><?php echo number_format($tDue,2)
                                    ?></span> </td>
                                <td class="no-print"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
