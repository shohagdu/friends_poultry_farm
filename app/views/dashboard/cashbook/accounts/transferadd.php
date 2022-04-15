<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div >
                        <h3 class="box-title">Bank Balance Transfer</h3>
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <?php echo $this->session->flashdata('msg'); ?>
                        <?php } ?>

                        <a href="<?php echo site_url('cashbook/transferHistory'); ?>"
                           class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-th-list"></i>
                            Transfer Record</a>

                    </div>
                </div>
                <div class="box-body">
                    <div class="col-md-8">
                        <form action="<?php echo base_url('cashbook/addbalancetransfer'); ?>" method="post"
                              id="transferInfoFrom"
                              class="form-horizontal">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label>From Account</label>
                                    <select name="fromtransactionAccountID" onchange="checkingSameBankAcc()" id="from_id"
                                            class="form-control select2 bank_id" style="width: 100%;">
                                        <option value="">Select From Account</option>
                                        <?php if(!empty($accounts)){
                                            foreach ($accounts as $account) { ?>
                                                <option value="<?php echo $account->accountID; ?>">
                                                    <?php echo $account->accountName; ?>
                                                    <?php echo $account->accountNumber; ?>
                                                </option>
                                            <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                    <label> Available Balance</label>
                                    <input name="transactionAmount" id="availableAmount" onkeyup="checkAvailableGreater()"
                                           class="form-control av_amount" readonly placeholder="Available Balance">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label>To Account</label>
                                    <select name="totransactionAccountID" id="to_id" onchange="checkingSameBankAcc()"
                                            class="form-control select2" style="width: 100%;">
                                        <option value="">Select To Account</option>
                                        <?php if(!empty($accounts)){
                                            foreach ($accounts as $account) { ?>
                                                <option value="<?php echo $account->accountID; ?>">
                                                    <?php echo $account->accountName; ?>
                                                    <?php echo $account->accountNumber; ?>
                                                </option>
                                            <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                    <label>Amount</label>
                                    <input name="transactionAmount" id="transAmount" onkeyup="checkAvailableGreater()"  class="form-control" placeholder="Amount" required>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                <label> Available Balance</label>
                                <input name="cDate" id="datepicker" class="form-control"
                                       value="<?php echo date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                    <label>Note</label>
                                    <textarea class="textarea" name="transactionNote" placeholder="Note"
                                              style="width: 100%; height: 60px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="box-body" id="alert_error" style="display: none;">      <div  class="callout callout-danger">
                                        <span id="show_error_save_info"></span>
                                    </div>
                                </div>
                                <div class="box-body" id="alert" style="display: none;">      <div  class="callout
                                callout-info">
                                        <span id="show_message"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-4">
                                    <button type="button" id="updateBtn" onclick="saveBankTransfer()" class="btn
                                    btn-success
                                    btn-block
                                btn-lg "><i class="glyphicon glyphicon-ok-sign"></i>
                                        Save
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
