<style>
    @media print
    {    
        .no-print, .no-print *
        {
            display: none !important;
        }
        a[href]:after {
            content: none !important;
        }
    }
    address p {
        margin: 0px;
    }
</style>

<section class="content">
    <?php
    if (!empty($_POST['supplier_id'])) {
        $supplier_id = $_POST['supplier_id'];
        $date_range = $_POST['date_range'];
        $date = explode("-", $date_range);
        if (!empty($supplier_id)) {
            $this->db->where('supplier_id', $supplier_id);
        }
        if (!empty($date_range)) {
            $this->db->where('date >= ', $date[0]);
            $this->db->where('date <= ', $date[1]);
        }
        $suppliers_payment = $this->db->get('tbl_pos_supplier_payment')->result_array();
        $supplerName = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_suppliers', 'supplierID', $supplier_id);
    } else {
        if (!empty($supplier_id)) {
            $this->db->where('supplier_id', $supplier_id);
        }
        $suppliers_payment = $this->db->from('tbl_pos_supplier_payment')->order_by("payment_id", "DESC")->get()->result_array();
        $supplerName = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_suppliers', 'supplierID', $supplier_id);
        $date_range=date('Y-m-d').'-'.date('Y-m-d');
        
    }


    $success = $this->session->flashdata('success');
    if ($success) {
        ?> 

        <div class="box box-info">
            <div class="box-body">
                <div class="callout callout-info">
                    <?php
                    echo $success;
                    ?>
                </div>
            </div><!-- /.box-body -->
        </div>

        <?php
    }

    $failed = $this->session->flashdata('failed');
    if ($failed) {
        ?>

        <div class="box box-info">
            <div class="box-body">

                <b style="color: red;">
                    <?php
                    echo $failed;
                    ?>
                </b>

            </div><!-- /.box-body -->
        </div>

        <?php
    }
    ?>
    <?php
    $supplier = $this->db->get('tbl_pos_suppliers')->result_array();
    ?>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title no-print">Supplier Payment Report</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group  no-print">
                            <div class="col-md-3">
                                <div class="form-group has-feedback">
                                    <label>Supplier</label>
                                    <div class="input-group">
                                        <select  name="supplier_id" class="form-control select2" required>
                                            <option value="">(:- Supplier -:)</option>
                                            <?php foreach ($supplier as $each_supplier) { ?>
                                                <option <?php
                                                if (!empty($supplier_id) && $supplier_id == $each_supplier['supplierID']) {
                                                    echo "selected";
                                                }
                                                ?> value="<?php echo $each_supplier['supplierID']; ?>"><?php echo $each_supplier['supplierName']; ?></option>
                                                <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <label>Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="date_range" value="<?php
                                    if (!empty($date_range)) {
                                        echo $date_range;
                                    }
                                    ?>" id="reservation" placeholder="Date Range" class="form-control pull-right" required>
                                </div><!-- /.input group -->
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <div class="input-group">
                                    <button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-search"></i> &nbsp;&nbsp;Search</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <div class="input-group">
                                    <button  class="btn btn-info btn-sm"  type="button" onclick="window.print();" ><i class="fa fa-print"></i> &nbsp;&nbsp;Print</button> &nbsp;

                                    <a href="<?php echo site_url('Suppliers/supplierPayment') ?>"  class="btn btn-danger btn-sm"   ><i class="fa fa-backward"></i> &nbsp;&nbsp;Back</a>

                            </div>
                        </div>
                    </div>
                    <br>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <?php if (!empty($supplerName['supplierName'])): ?>

                                <tr style="font-size:16px;font-weight: bold;">
                                    <td>Suppliler: </td>
                                    <td colspan="2"><?php echo $supplerName['supplierName']; ?></td>
                                    <td colspan="4" style="text-align:center;">Date Range : <?php echo $date_range; ?> </td>

                                </tr>

                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="font-weight:bold;font-size: 18px;">
                                        Supplier Payment History
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </thead> 
                        <tbody>
                            <tr>
                                <th style="width:5%;">SL.</th>
                                <th style="width:20%">Date</th>
                                <th style="width:20%">Supplier</th>
                                <th style="width:20%"> Account</th>
                                <th>Payment</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>


                            <?php
                            if (!empty($suppliers_payment)):

                                $total_amount = '';
                                foreach ($suppliers_payment as $key => $supplier) {
                                    $suppler_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_suppliers', 'supplierID', $supplier['supplier_id']);
                                    $account_name = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_accounts', 'accountID', $supplier['transactionAccountID']);
                                    $total_amount += $supplier['amount'];
                                    ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $supplier['date']; ?></td>
                                        <td><?php echo $suppler_name['supplierName']; ?></td>
                                        <td><?php echo $account_name['accountName']; ?></td>
                                        <td><?php echo $supplier['amount']; ?></td>
                                        <td><?php echo $supplier['note']; ?></td>

                                        <td><a href="<?php echo site_url('Suppliers/supplierPaymentDetailsInfo/'.$supplier['payment_id']); ?>" class="btn btn-primary btn-xs ">View</a></td>
                                    </tr>

                                <?php } ?>
                            <tfoot>
                                <tr>
                                    <td style="text-align: right;color:green;font-weight: bold;" colspan="4"> Total Payment : </td>
                                    <td colspan="3" style="color:green;font-weight: bold;"><?php echo number_format($total_amount, 2); ?>/=</td>


                                </tr>
                            </tfoot>
                        <?php else: ?>
                            <tr>
                                <td style="text-align: center;color:red;" colspan="6">
                                    No transaction found
                                </td>
                            </tr>
                        <?php endif; ?>

                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>


                </div><!-- /.box-body -->

                <div class="box-footer">


                </div>
            </form>
        </div><!-- /.box -->
</section>
<div class="clearfix"></div>
















