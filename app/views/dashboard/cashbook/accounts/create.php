<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">New Account Information</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                    <a href="<?php echo site_url('cashbook/Accountindex'); ?>" class="btn btn-primary btn-sm
                    pull-right" title="Record"><i class="glyphicon glyphicon-th-list"></i> Record</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-8">
                    <form action="<?php echo base_url('cashbook/Accountstore'); ?>" method="post">
                        <div class="form-group has-feedback">
                            <label>Account Name</label>
                            <input required name="accountName" class="form-control" placeholder="Account Name">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Account Type</label>
                            <select id="accountType" required name="accountType" class="form-control select2" style="width:100%;">
                                <option value="">Select One</option>
                                <option value="CASH">Cash</option>
                                <option value="BANK">Bank</option>
                            </select>
                        </div>
                        <div style="display: none" class="accountNumber form-group has-feedback">
                            <label>Account Number</label>
                            <input name="accountNumber" class="form-control" placeholder="Account Number">
                        </div>
                        <div style="display: none" class="branchName form-group has-feedback">
                            <label>Branch Name</label>
                            <input name="accountBranchName" class="form-control" placeholder="Branch Name">
                        </div>
                        <div  class=" form-group has-feedback">
                            <label>Opening Balance</label>
                            <input name="openingBal" class="form-control" placeholder="Opening Balance">
                        </div>

                        <div class="form-group has-feedback">
                            <label>Note</label>
                            <textarea class="textarea" name="note"  placeholder="Note" style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        </div>

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-xs-4">
                                <button type="submit" class="btn btn-success btn-block btn-lg "><i
                                            class="glyphicon glyphicon-ok-sign"></i>
                                    Save
                                </button>
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