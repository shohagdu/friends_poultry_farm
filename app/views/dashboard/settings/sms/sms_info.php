<section class="content">
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">SMS History</h3>
                    <?php if ($this->session->flashdata('msg')) {
                        echo $this->session->flashdata('msg');
                    } ?>
                    <?php if ($this->session->flashdata('usingTransaction')) {
                        echo $this->session->flashdata('usingTransaction');
                    } ?>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width:5%;">SL.</th>
                            <th>Date</th>
                            <th style="width:10%;">Pending Sms</th>
                            <th style="width:10%;">Total Sms</th>
                            <th style="width:20%;">Successfully Sms Send</th>
                            <th style="width:20%;">Failed Sms Send</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $sl = 1; 
                       
                        if(!empty($sms_info)){ foreach ($sms_info as $sms) { ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                                
                                <td><?php echo date('d-m-Y',strtotime($sms->sms_date)); ?></td>
                                <td><?php echo $sms->pending_sms; ?></td>
                                <td><?php echo $sms->total_sms; ?></td>
                                <td><a href="<?php echo base_url('settings/show_sms_details/1/'.$sms->sms_date); ?>"><?php echo $sms->success_sms; ?></a></td>
                                <td><a href="<?php echo base_url('settings/show_sms_details/2/'.$sms->sms_date); ?>"><?php echo $sms->failed_sms; ?></a></td>
                               
                            
                            </tr>
                            <?php $sl++; ?>
                        <?php }} ?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
</section>



<!-- /.content -->