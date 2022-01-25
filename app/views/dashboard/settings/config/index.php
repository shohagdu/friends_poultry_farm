<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Basic Configuration</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                </div>
                <div class="box-body">
                    <div class="col-sm-offset-2 col-sm-8">
                        <form action="<?php echo base_url('settings/updateStoreVatRate'); ?>" method="post">
                            <div class="form-group has-feedback">
                                <label>Vat Rate (%)</label>
                                <input value="<?php echo $config->configID; ?>" name="configID" type="hidden">
                                <input value="<?php echo $config->vatRate; ?>" name="vatRate" class="form-control"
                                       placeholder="Vat Rate">
                            </div>


                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit"  class="btn btn-success btn-sm">VAT Rate Update</button>
                                </div>

                                <!-- /.col -->
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <br/>
                        <form action="<?php echo base_url('settings/updateStoreSmsRate'); ?>" method="post">
                            <div class="form-group has-feedback">
                                <label>SMS Rate </label>
                                <div class="clearfix"></div>
                                <div class="checkbox">
                                    <label><input type="checkbox" <?php if($smsConfigData->is_sms_costing==1){ echo "Checked";} ?> name="apply_sms_costing" value="">Apply SMS Cost</label>
                                </div>
                                <div class="col-sm-12" style="height:10px;"></div>
                                <input value="<?php echo $smsConfigData->sms_costing; ?>" name="smsRate" class="form-control"
                                       placeholder="Sms Costing">
                            </div>


                            <div class="row">
                                <!-- /.col -->
                                <div class="col-xs-4">
                                    <button type="submit" name="updateSmsAmount" class="btn btn-success btn-sm">Sms Rate Update</button>
                                    <input type="hidden" name="update_id" value="<?php echo $smsConfigData->id  ?>">
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