<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice</title>
    <base href="http://localhost/istiaq/pos/"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/image/favicon.ico">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <style type="text/css" media="all">
        body {
            color: #000;
        }

        #wrapper {
            max-width: 480px;
            margin: 0 auto;
            padding-top: 20px;
        }

        .btn {
            border-radius: 0;
            margin-bottom: 5px;
        }

        .bootbox .modal-footer {
            border-top: 0;
            text-align: center;
        }

        h3 {
            margin: 5px 0;
        }

        .order_barcodes img {
            float: none !important;
            margin-top: 5px;
        }

        @media print {
            .no-print {
                display: none;
            }

            #wrapper {
                max-width: 480px;
                width: 100%;
                min-width: 250px;
                margin: 0 auto;
            }

            .no-border {
                border: none !important;
            }

            .border-bottom {
                border-bottom: 1px solid #ddd !important;
            }
        }
        #tableStyle td{
            padding-top:2px;
            padding-bottom:2px;
        }
        #tableStyle th{
            padding-top:2px;
            padding-bottom:2px;
        }
    </style>
</head>

<body>
<div id="wrapper">
    <div id="receiptData">
        <div class="no-print"></div>
        <div id="receipt-data">
            <div class="text-center">
                <div style="text-transform:uppercase;font-weight:bold;font-size:18px;"><?php echo $appConfig->company_info ?></div>
                <div class="col-sm-12" style="font-size:11px;"><?php echo $appConfig->address ?></div>
                <div class="col-sm-12" style="font-size:11px;"><?php echo $appConfig->contactNo ?></div>
            </div>
            <?php
            $user = $this->session->userdata('user');
            $admin_data = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_users', 'userID', $user);
            //echo "<pre>";
          //  print_r($sales);
            ?>
            <div>
                <table style="width:100%;font-size:9px;margin:10px 0px 10px 5px;">
                    <tr>
                        <th style="width:17%;">Customer Name:</th>
                        <td style="width:28%;"><?php echo !empty($sales->customer_name)?$sales->customer_name:'-'; ?></td>
                        <th style="width:35%;text-align:right">Date:</th>
                        <td style="width:30%;padding-left:10px;"><?php echo !empty($sales->sales_date)? date("d-m-Y", strtotime($sales->sales_date)):'';   ?></td>
                    </tr>
                    <tr>
                        <th>Mobile:</th>
                        <td><?php echo !empty($sales->customer_mobile)?$sales->customer_mobile:'-'; ?></td>
                        <th style="text-align:right">Sale No:</th>
                        <td style="padding-left:10px;"><?php echo !empty($sales->invoice_no)?$sales->invoice_no:'';
                        ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <th style="text-align:right">Sales Person:</th>
                        <td style="padding-left:10px;"> <?php echo  !empty($sales->user_name)?ucwords
                            ($sales->user_name):''; ?></td>

                    </tr>
                </table>
            </div>
            <div style="clear:both;"></div>
            <table class="table table-bordered"  id="tableStyle" style="font-size:10px;width:100%">
                <thead>
                <tr>
                    <th style="width:1%">SL</th>
                    <th style="width:40%">Product Info</th>
                    <th style="width:8%">Quantity</th>
                    <th style="width:15%">Price</th>
                    <th style="width:15%" class="text-right">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sl = 1;
                if(!empty($sales->product_info)){
                foreach ($sales->product_info as $product) {

                    ?>
                    <tr>
                        <td><?php echo $sl; ?></td>
                        <td class="no-border">
                            <?php echo $product->product_name . '[' . $product->bandTitle . ']'; ?>
                        </td>


                         <td class="no-border border-bottom " style="text-align:center;">
                            <?php echo $product->total_item; ?>
                        </td>

                         <td class="no-border border-bottom pull-center" style="text-align:center;">
                           <?php echo $product->unit_price; ?>
                        </td>

                        <td class="no-border border-bottom text-right" style="text-align:right;">
                            <?php echo number_format($product->total_item * $product->unit_price,2); ?>
                        </td>
                    </tr>
                    <?php $sl++; ?>
                <?php } } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th   colspan="4" style="text-align:right">Sub Total </th>
                        <th class="text-right"><?php echo !empty($sales->sub_total)? number_format
                            ($sales->sub_total,2):'0.00';   ?></th>
                    </tr>
                    <tr>
                        <th  colspan="4" style="text-align:right">Discount</th>
                        <th class="text-right"><?php echo !empty($sales->discount)? number_format($sales->discount,
                                2):'0.00';   ?></th>
                    </tr>
                    <tr>
                        <th  colspan="4"  style="text-align:right">Net Total</th>
                        <th class="text-right"><?php echo !empty($sales->net_total)? number_format
                            ($sales->net_total,2):'0.00';   ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-right"><?php $paymentBy= !empty($sales->payment_by)? json_decode
                            ($sales->payment_by,true):'';
                        if(!empty($paymentBy)){
                        ?>
                            <table class=" table-bordered" style="width:50%;float: right;">
                                <?php
                                $paymentKey=[
                                  'cash'=>'Cash',
                                  'cash_cheque'=>'Cash Cheque',
                                  'due_cheque'=>'Due Cheque',
                                  'online_payment'=>'Online Payment',
                                ];
                                if(!empty($paymentBy)){
                                    $ik=1;
                                    foreach ($paymentBy as $key=> $value){
                                ?>
                                <tr>
                                    <?php
                                    if($ik==1){
                                    ?>
                                        <td rowspan="4" style="border:1px solid #fff;border-right:1px solid #d0d0d0;
                                        padding-right:8px;
">Payment By</td>
                                    <?php } ?>
                                    <td style="padding-right:8px; "><?php echo !empty
                                        ($paymentKey[$key])
                                            ?$paymentKey[$key]:''; ?></td>
                                    <td style="width:33%;"><?php echo !empty($value)? number_format($value,2):'0.00'
                                        ?></td>
                                </tr>
                                <?php  $ik++; } } ?>
                            </table>
                            <?php } ?>
                        </th>
                    </tr>
                    <tr>
                        <th  colspan="4"  style="text-align:right">Total Payment AMT</th>
                        <th class="text-right"><?php echo !empty($sales->payment_amount)? number_format
                            ($sales->payment_amount,2):'0.00';   ?></th>
                    </tr>

                    <?php
                        if(!empty($sales->remaining_due_make_discount) || $sales->remaining_due_make_discount>0){
                    ?>
                        <tr>
                            <th  colspan="4"  style="text-align:right">Remaining Due Make Discount</th>
                            <th class="text-right"><?php echo !empty($sales->remaining_due_make_discount)? number_format
                                ($sales->remaining_due_make_discount,2):'0.00';   ?></th>
                        </tr>
                    <?php
                    }else{
                    ?>
                        <tr>
                            <th  colspan="4"  style="text-align:right">Current Due AMT</th>
                            <th class="text-right"><?php echo !empty($sales->current_due_amt)? number_format
                                ($sales->current_due_amt,2):'0.00';   ?></th>
                        </tr>
                    <?php
                    }
                     if(!empty($sales->customer_id)){
                    ?>

                        <tr>
                            <th  colspan="4"  style="text-align:right">Previous Due AMT</th>
                            <th class="text-right"><?php echo !empty($sales->previous_due)? number_format
                                ($sales->previous_due,2):'0.00';   ?></th>
                        </tr>
                        <tr>
                            <th  colspan="4"  style="text-align:right">Total Payable AMT</th>
                            <th class="text-right"><?php echo !empty($sales->total_due)? number_format($sales->total_due,
                                    2):'0
                            .00';   ?></th>
                        </tr>
                    <?php }?>
                </tfoot>
            </table>

        </div>

        <div class="order_barcodes text-center">
            <div class="text-center" style="font-size: 10px "> Thank you for shopping with us. Please come again.</div>
            <span style="font-size:9px;"><b> Copyright &copy; www.shohozit.com, Developed By Omar Shohag, Cell: 01839707645 </b></span>
        </div>
        <div style="clear:both;"></div>
    </div>

    <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
        <br/>
        <div class="col-xs-6">
        </div>
        <div class="pull-right col-xs-6">
                    <button onclick="window.print();" onfocus="true" class="btn btn-block btn-primary"><i class="glyphicon glyphicon-print"></i> Print</button>

        </div>
        <div class="col-xs-12">
            <div class="row">
                <div class="pull-right col-xs-6">
                    <?php if( $this->session->userdata('user_role')!=5){ ?>
                    <a class="btn btn-block btn-danger" href="<?php echo base_url('pos'); ?>"><i class="glyphicon glyphicon-backward"></i>  Sales</a>
                    <?php } ?>
                </div>

            <div class="pull-right col-xs-6">
                    <a class="btn btn-block btn-warning" href="<?php echo base_url('welcome'); ?>"><i class="glyphicon glyphicon-backward"></i>  Dashboard</a>
            </div>

            </div>

        </div>

        <div style="clear:both;"></div>
        <div class="col-xs-12" style="background:#F5F5F5; padding:10px;">
            <p style="font-weight:bold;">
                Please don't forget to disble the header and footer in browser print settings.
            </p>
            <p style="text-transform: capitalize;">
                <strong>FF:</strong> File &gt; Print Setup &gt; Margin &amp; Header/Footer Make all --blank--
            </p>
            <p style="text-transform: capitalize;">
                <strong>chrome:</strong> Menu &gt; Print &gt; Disable Header/Footer in Option &amp; Set Margins to None
            </p>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
</body>
</html>