
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Shop configuration</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                </div>
                <div class="box-body">
                    <?php
                        $message=(!empty($posConfig->smsText)?json_decode($posConfig->smsText,true):'');
                    ?>
                    <div class="col-sm-10">
                        <form action="<?php echo base_url('settings/PosConfigUpdate'); ?>" class="form-horizontal" method="post">
                            <div class="form-group has-feedback">
                                <label class="col-sm-4  text-right">Shop Name </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="Enter Shop Name"
                                           name="shopName" value="<?php echo
                                    (!empty
                                    ($posConfig->company_info)
                                    ?$posConfig->company_info:'') ?>">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-4  text-right">Address</label>
                                <div class="col-sm-8">
                                     <textarea  class="form-control" placeholder="Enter Address"  name="address" ><?php
                                         echo
                                         (!empty
                                         ($posConfig->address)
                                             ?$posConfig->address:'') ?></textarea>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-4  text-right">Contact Info</label>
                                <div class="col-sm-8">
                                    <textarea  class="form-control" placeholder="Enter Contact  Information "  name="contact_info" ><?php echo (!empty
                                        ($posConfig->contactNo)?$posConfig->contactNo:'') ?></textarea>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-4 text-right">Contact Person</label>
                                <div class="col-sm-8">
                                <input type="text" name="contact_person"  placeholder="Enter Contact Person Information " class="form-control"
                                       value="<?php echo
                                (!empty($posConfig->contactPerson)
                                    ?$posConfig->contactPerson:'') ?>">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-4 text-right">Sales Message</label>
                                <div class="col-sm-8">
                                <textarea name="salesMessage"  rows="6" placeholder="Enter Sales Message Information"
                                          class="form-control"><?php echo (!empty($message['sales'])
                                        ?$message['sales']:'') ?></textarea>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="col-sm-4 text-right">Payment Message</label>
                                <div class="col-sm-8">
                                <textarea name="paymentMessage"  rows="6" placeholder="Enter Payment Message" class="form-control"><?php echo (!empty($message['payment'])
                                        ?$message['payment']:'') ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                </div>
                                <div class="col-xs-4">
                                    <input type="hidden" name="update_id" value="<?php echo (!empty($posConfig->id)
                                        ?$posConfig->id:'') ?>">
                                    <button type="submit" class="btn btn-primary btn-md "><span class="glyphicon
                                    glyphicon-ok-sign"></span> Update</button>
                                </div>
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