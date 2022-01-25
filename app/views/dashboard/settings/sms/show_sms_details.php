<section class="content">
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">SMS History of date(<?php echo (!empty($this->uri->segment(4))?date('d-m-Y',strtotime($this->uri->segment(4))):''); ?>)</h3>
                    <?php if ($this->session->flashdata('msg')) {
                        echo $this->session->flashdata('msg');
                    } ?>
                    <?php if ($this->session->flashdata('usingTransaction')) {
                        echo $this->session->flashdata('usingTransaction');
                    } ?>
                     <a href="<?php echo base_url('settings/get_sms_report'); ?>" class="btn btn-danger btn-xs pull-right"><i
                                class="glyphicon glyphicon-forward"></i> Back
                    </a>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="#" method="post" id="resend_sms_form">
                    <table id="example1"   class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width:5%;">SL.</th>
                            <th style="width:5%;">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th style="width:20%;">Name</th>
                            <th style="width:10%;">Mobile</th>
                            <th >SMS</th>
                            <th >Sending Time</th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $sl = 1; 
                       
                       
                        if(!empty($sms_info)){ foreach ($sms_info as $sms) { ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                     
                                <td>
                                    <?php if($this->uri->segment(3)==2){ ?>
                                         <input type="checkbox" name="ids[<?php echo $sms->id; ?>]" id="sms_log_id_<?php echo $sms->id ?>">
                                         <?php 
                                    }
                                   ?>
                                 </td>
                                <td><?php echo $sms->name."(".$sms->member_code.")"; ?></td>
                                <td><?php echo $sms->mobile_number; ?></td>
                                <td><?php echo $sms->msg; ?></td>
                                <td><?php echo date('h:i a',strtotime($sms->ins_date)); ?></td>
                             </tr>
                            <?php $sl++; ?>
                        <?php }} ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <button type="button" id="resend_sms_info" onclick="sendResendSms()" class="btn btn-info btn-lg btn-block pull-right"><i
                                class="glyphicon glyphicon-ok-sign"></i> Re send SMs
                    </button>
                                </td>
                                 <td colspan="3">
                                     <div id="show_response_info"></div>
                                     </td>
                                
                            </tr>
                        </tfoot>
                    </table>
                    </form>
                    
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
</section>
<script>
   $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    function sendResendSms(){
         $("#resend_sms_info").attr("disabled", true);
        $.ajax({
            type: "POST",
            url: "<?php  echo base_url('/settings/save_resend_sms');?>",
            data: $('#resend_sms_form').serialize(),
            success: function (response) {
                $("#resend_sms_info").attr("disabled", false);
                $("#show_response_info").html(response);
               
                setTimeout(function() {
                    window.location.reload();
                }, 5000);
                
            }
       });
    }
</script>


<!-- /.content -->