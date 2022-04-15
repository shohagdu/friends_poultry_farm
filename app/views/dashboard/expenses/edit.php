<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">New Expense</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                    <a href="<?php echo site_url('expenses/index'); ?>"
                       class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> Record</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-8">
                        <form action="" method="post" id="expenseForm" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label>Expense Category</label>
                                    <select required name="head_id" class="form-control  select2"
                                            style="width: 100%;">
                                        <option value="">-- Select Expense Category --</option>
                                        <?php if(!empty($expensehead)){ foreach ($expensehead as $expHead) { ?>
                                            <option value="<?php echo $expHead->id; ?>" <?php
                                            echo ((!empty($expenseInfo->expense_ctg) &&
                                            $expenseInfo->expense_ctg==$expHead->id)?"selected":'') ?>><?php echo $expHead->title; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <label>Account</label>
                                    <select required name="account_id" class="form-control select2 bank_id"
                                            style="width: 100%;">
                                        <option value="">-- Select Account --</option>
                                        <?php if(!empty($account)){ foreach ($account as $eachaccount) { ?>
                                            <option value="<?php echo $eachaccount->accountID; ?>" <?php
                                            echo ((!empty($expenseInfo->expense_ctg) &&
                                                $expenseInfo->expenseBankID==$eachaccount->accountID)?"selected":'') ?>><?php echo
                                                $eachaccount->accountName; ?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                    <label>Amount</label>
                                    <input required="" id="transAmount" value="<?php
                                    echo ((!empty($expenseInfo->debit_amount))?$expenseInfo->debit_amount:'') ?>" name="amount"
                                           class="form-control " placeholder="Amount">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                    <label>Date</label>
                                    <input required="" value="<?php
                                    echo ((!empty($expenseInfo->payment_date))?$expenseInfo->payment_date:'') ?>"  id="datepicker" name="date"
                                           class="form-control" placeholder="YYYY-MM-DD">
                                </div>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="col-xs-12">
                                    <label>Remarks/Note</label>
                                    <textarea name="note" class="form-control "  placeholder="Enter  Remarks/Note"><?php
                                        echo ((!empty($expenseInfo->remarks))?$expenseInfo->remarks:'') ?></textarea>
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
                                    <input type="hidden" value="<?php
                                    echo ((!empty($expenseInfo->id))?$expenseInfo->id:'') ?>"  name="updateID" class="form-control" >

                                    <button type="button" id="updateBtn" onclick="saveExpenseInfo()" class="btn
                                    btn-success
                                    btn-block
                                btn-lg "><i class="glyphicon glyphicon-ok-sign"></i>
                                        Update
                                    </button>
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