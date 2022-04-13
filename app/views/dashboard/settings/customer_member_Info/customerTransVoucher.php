<section class="content">
    <div class="row">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header no-print">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <a class="btn btn-danger pull-right" style="margin-left: 5px" href="<?php echo base_url('settings/customer_due_collection')
                    ?>"><i  class="glyphicon glyphicon-backward"></i> Back </a>
                    <button class="btn btn-primary pull-right" onclick="print()"><i
                            class="glyphicon glyphicon-print"></i> Print
                    </button>

                </div>
                <div class="clearfix"></div>
                <div class="box-body">
                    <table class="invoice">
                        <tbody>
                            <tr>
                                <td>
                                    <?php echo (!empty($transactionInfo->customerName)
                                        ?$transactionInfo->customerName:'-')
                                    ?>
                                    <br>
                                    <?php echo (!empty($transactionInfo->customerMobile)
                                        ?$transactionInfo->customerMobile:'')
                                    ?>
                                    <br>
                                    <?php echo (!empty($transactionInfo->address)
                                        ?$transactionInfo->address:'')
                                    ?>
                                    <br>


                                    Invoice # <?php echo (!empty($transactionInfo->transCode)?$transactionInfo->transCode:'') ?><br>
                                    <?php echo (!empty($transactionInfo->payment_date)?date('d M, Y',strtotime
                                    ($transactionInfo->payment_date)):'') ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <?php
                                                    echo (!empty($transactionType[$transactionInfo->type])
                                                            ?$transactionType[$transactionInfo->type]:'')
                                                    ?>
                                                </td>
                                                <td class="alignright"><?php echo (!empty($transactionInfo->debit_amount)
                                                        ?$transactionInfo->debit_amount:(!empty
                                                        ($transactionInfo->credit_amount)
                                                            ?$transactionInfo->credit_amount:''))
                                                    ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* -------------------------------------
    INVOICE
    Styles for the billing table
------------------------------------- */
    .invoice {
        margin: 40px auto;
        text-align: left;
        width: 80%;
    }
    .invoice td {
        padding: 5px 0;
    }
    .invoice .invoice-items {
        width: 100%;
    }
    .invoice .invoice-items td {
        border-top: #eee 1px solid;
    }
    .invoice .invoice-items .total td {
        border-top: 2px solid #333;
        border-bottom: 2px solid #333;
        font-weight: 700;
    }
</style>

