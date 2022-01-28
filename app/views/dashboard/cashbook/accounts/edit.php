<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Update Account Information</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                    <a href="<?php echo site_url('cashbook/Accountindex'); ?>" class="btn btn-primary btn-sm
                    pull-right" title="Record"><i class="glyphicon glyphicon-th-list"></i> Record</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-8">
                        <form action="<?php echo base_url('Cashbook/AccountUpdate'); ?>" method="post">
                            <div class="form-group has-feedback">
                                <label>Account Name</label>
                                <input value="<?php echo $accounts[0]->accountName; ?>" name="accountName"
                                       class="form-control" placeholder="Account Name">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Account Type</label>
                                <select id="accountType" name="accountType" class="form-control"
                                        style="width: 100%;">
                                    <option value="">Select One</option>
                                    <option <?php echo(($accounts[0]->accountType == 'CASH') ? 'selected' : '') ?>
                                            value="CASH">Cash
                                    </option>
                                    <option <?php echo(($accounts[0]->accountType == 'BANK') ? 'selected' : '') ?>
                                            value="BANK">Bank
                                    </option>
                                </select>
                            </div>

                            <?php if($accounts[0]->accountType == 'BANK'){
                                $display = 'display: block;';
                            }else{
                                $display = 'display: none;';
                            }?>
                            <div style="<?php echo $display; ?>" class="accountNumber form-group has-feedback">
                                <label>Account Number</label>
                                <input value="<?php echo $accounts[0]->accountNumber; ?>" name="accountNumber" class="form-control" placeholder="Account Number">
                            </div>
                            <div style="<?php echo $display; ?>" class="branchName form-group has-feedback">
                                <label>Branch Name</label>
                                <input value="<?php echo $accounts[0]->accountBranchName; ?>" name="accountBranchName" class="form-control" placeholder="Branch Name">
                            </div>
                            <div  class=" form-group has-feedback">
                                <label>Opening Balance</label>
                                <input name="openingBal" value="<?php echo (!empty($accounts[0]->openingBal)?$accounts[0]->openingBal:'0.00') ?>" class="form-control" placeholder="Opening Balance">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Note</label>
                                <textarea class="textarea" name="note" placeholder="Note"
                                          style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $accounts[0]->note; ?></textarea>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Status</label>
                                <select id="softDelete" name="softDelete" class="form-control"
                                        style="width: 100%;">
                                    <option value="">Select One</option>
                                    <option <?php echo(($accounts[0]->softDelete == 0) ? 'selected' : '') ?>
                                            value="0">Active
                                    </option>
                                    <option <?php echo(($accounts[0]->softDelete == 1) ? 'selected' : '') ?>
                                            value="1">Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <button type="submit" class="btn btn-success btn-block btn-lg "><i
                                                class="glyphicon glyphicon-ok-sign"></i>
                                        Update
                                    </button>
                                    <input value="<?php echo $accounts[0]->accountID; ?>" name="accountID"
                                           type="hidden">
                                    <input value="<?php echo $accounts[0]->accountName; ?>" name="original-accountName" type="hidden">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>