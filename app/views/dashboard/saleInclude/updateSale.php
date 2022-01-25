<?php
include ('salesHeader.php')
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <form action="<?php echo base_url('pos/store'); ?>" id="salesForm" method="post">
            <section class="content">
                <div class="row">
                    <div class="col-sm-12" style="background: #fff">
                        <div class="col-sm-8" style="margin-top:10px;">
                            <div class="form-group" >
                                <div class="col-sm-7 search col-xs-12"  style="margin-bottom:10px;">
                                    <div class="row">
                                        <span class="glyphicon glyphicon-search"></span>
                                        <input required="" name="cst_name"
                                               placeholder="Name/Mobile/Email/ Address"
                                               class="customer form-control" onfocus="true"
                                               id="tags_11">
                                        <input type="hidden" value="<?php echo (!empty($sales->customer_id)?$sales->customer_id:'') ?>" name="customer" id="cst_id"/>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-4" >
                                    <button type="button" class="btn btn-info" data-toggle="modal" onclick="addCustomerMemberInfoPos()"
                                            data-target="#CustomerInfoModal" tabindex="-1"><i class="glyphicon glyphicon-plus"></i> Add</button>
                                </div>
                                <div class="col-sm-4 col-xs-8 text-center" style="padding-top:5px" >
                                    <div class="form-check">
                                        <input class="form-check-input" tabindex="-1" checked type="checkbox" value="1" name="allAreRunningCustomer" id="allAreRunningCustomer">
                                        <label class="form-check-label" for="allAreRunningCustomer">
                                            All are  Running Customer
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <div class="panel panel-default " style="margin-top:5px">
                                <div class="panel-body"
                                     style="height:50px;padding-top:6px;">
                                    <div style="font-size:10px;font-weight:bold;float:left;text-decoration:underline"> Customer Information:
                                    </div>
                                    <table style="width:100%;font-size:11px;"
                                           >
                                        <tr>
                                            <th style="width:15%;">Name</th>
                                            <td style="width:35%;">: <span id="showName"><?php echo (!empty($sales->customer_name)?$sales->customer_name:'') ?></span>
                                            </td>
                                            <th style="width:15%;ext-align:right;">Mobile</th>
                                            <td style="width:35%;">: <input type="hidden"
                                                                            id="member_mobile"
                                                                            name="member_mobile">
                                                <span id="mobile"><?php echo (!empty($sales->customer_mobile)?$sales->customer_mobile:'') ?></span></td>
                                        </tr>

                                        <tr>
                                            <th>Address</th>
                                            <td >: <span
                                                    id="showAddress"><?php echo (!empty($sales->address)?$sales->address:'') ?></span></td>
                                            <th >Email
                                            </th>
                                            <td >: <span
                                                    id="showEmail"><?php echo (!empty($sales->email)?$sales->email:'') ?></span></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="col-sm-12" style="">
                                <div class="row">
                                    <div class="form-group">
                                        <div class="search1">
                                            <span class="glyphicon glyphicon-search"></span>
                                            <input id="productName" class="form-control"
                                                   placeholder="Scan/Search Product by Name/Code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row " >
                                    <div class="col-md-12 col-xs-12 myStyleCss">
                                        <div class="row table-responsive"
                                             style="background: #fff;min-height:420px;border:1px solid #fff;">
                                            <table class="table"
                                                   style="background: #eee; border:2px solid #fff !important;width: 100%!important;"
                                                   rules="all"
                                            >
                                                <thead>
                                                <tr>
                                                    <th style="width: 30%;text-align:center;background: #737373;color:white;padding:10px;">
                                                        Product Information
                                                    </th>

                                                    <th style="10%;text-align:center;background: #737373;color:white;padding:10px;">
                                                        Price
                                                    </th>


                                                    <th style="20%;text-align:center;background: #737373;color:white;padding:10px;">
                                                        Qty
                                                    </th>
                                                    <th style="15%;text-align:center;background: #737373;color:white;padding:10px;">
                                                        Subtotal
                                                    </th>
                                                    <th style="15%;text-align:center;background: #737373;color:white;padding:10px;">
                                                        Action
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody id="tableDynamic">
                                                    <?php
                                                        if(!empty($sales->product_info)){
                                                            foreach ($sales->product_info as $productInfo){
                                                    ?>
                                                    <tr>
                                                        <td style="width:30%;" class="appenTd">
                                                            <?php echo (!empty($productInfo->product_name)?$productInfo->product_name:'').(!empty($productInfo->productCode)?' ['.$productInfo->productCode.']':'') ?>

                                                            <input value="<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>" tabindex="-1" name="itemDetailsID[]"  class="itemDetailsID" type="hidden">

                                                            <div style="color:red;font-size:11px;text-align: center" class="badge" id="qty_empty_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>"></div>
                                                        </td>
                                                        <td style="text-align:center;width:10%;" class="appenTd">
                                                            <input id="price_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>" value="<?php echo (!empty($productInfo->unit_price)?$productInfo->unit_price:'') ?>" tabindex="-1" name="price[]" style="text-align: center;height:30px;" class="unit_price" type="text">
                                                        </td>
                                                        <td style="text-align:center;width:15%;" class="appenTd">
                                                            <input id="qty_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>" type="text"
                                                                                                                        class="quantity form-control" name="qty[]" value="<?php echo (!empty($productInfo->total_item)?$productInfo->total_item:'') ?>" style="text-align: center;height:30px;"
                                                            >
                                                            <input id="productID_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>" name="productID[]" value="<?php echo (!empty($productInfo->product_id)?$productInfo->product_id:'') ?>" type="hidden">

                                                            <input id="inventory_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>" name="invantory[]" value="<?php echo (!empty($productInfo->currentItemStock)?$productInfo->currentItemStock+$productInfo->total_item:$productInfo->total_item) ?>" type="hidden">
                                                        </td>
                                                        <td style="width:15%;text-align:center;"  class=" appenTd" style="width:20%" id="total_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>">
                                                            <input id="sub_total_<?php echo (!empty($productInfo->id)?$productInfo->id:'') ?>" name="sub_total[]" class="totalprice" readonly style="text-align: center;height:30px;" value="<?php echo (!empty($productInfo->total_price)?$productInfo->total_price:'') ?>" tabindex="-1"   type="text">
                                                        </td>
                                                        <td class="appenTd" style="width:15%;text-align:center;padding-top:5px;padding-bottom:0px;"><button tabindex="-1" class="btn btn-danger btn-sm" id="removeRow"><i class="glyphicon glyphicon-trash" style="cursor:pointer;"></i>  </button></td>
                                                    </tr>
                                                <?php
                                                }
                                                            }
                                                        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-4"
                             style="background-color:#f2f2f2;min-height:420px;border:1px solid #fff;">
                            <table style="width:100%;">
                                <tbody>
                                <tr>
                                    <th class="thStyleNew">
                                        <a tabindex="-1" href="<?php echo site_url('pos'); ?>"
                                           class="btn btn-danger btn-sm"><i
                                                class="glyphicon glyphicon-refresh"></i> Clear Sale</a>
                                    </th>
                                    <td class="tdStyleNew">
                                        <div class="alert alert-warning" id="emptyMember" style="padding:5px;margin:0px">
                                            Customer Information is required
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="thStyleNew">
                                        Sales Date
                                    </th>
                                    <td class="tdStyleNew">
                                        <input type="text" tabindex="-1" readonly=""
                                               value="<?php echo (!empty($sales->sales_date)?date('d-m-Y',strtotime($sales->sales_date)):''); ?>"
                                               id="datepicker1"
                                               name="saleDate" class="form-control datepicker">

                                    </td>
                                </tr>
                                <tr>
                                    <th class="thStyleNew">
                                        Sub Total
                                    </th>
                                    <td class="tdStyleNew">
                                        <input tabindex="-1" id="subTotal"  readonly type="text" value="<?php echo (!empty($sales->sub_total)?$sales->sub_total:'0.00'); ?>"
                                               name="subTotal"
                                               class="form-control inputStyle">
                                    </td>
                                </tr>
                                <tr>
                                    <th class="thStyleNew" style="vertical-align:top;">Discount</th>
                                    <td style="border-top: medium none;">
                                        <label for="taka">&#2547;</label>
                                        <input <?php echo ((isset($sales->discount_type) && $sales->discount_type==0)?'checked':'')  ?> tabindex="-1" type="radio" id="taka"
                                               name="discountType"
                                               value="0">
                                        <label for="percent" style="padding-left: 20px;">&#37;</label>
                                        <input type="radio" <?php echo ((isset($sales->discount_type) && $sales->discount_type==1)?'checked':'')  ?> id="percent" name="discountType" value="1">

                                        <p id="percentP" style="display: <?php echo (!empty($sales->discount_percent)?'block':'none') ?> ;">
                                            <label for="discountPercent">Percent(%)</label>
                                            <input  placeholder="e.g 10" value="<?php echo (!empty($sales->discount_percent)?$sales->discount_percent:'0.00') ?>" name="discountPercent"
                                                    id="discountPercent"
                                                    class="form-control">
                                        </p>
                                        <p>
                                            <input tabindex="-1" name="discount" id="discount"
                                                   class="form-control inputStyle"
                                                   value="<?php echo (!empty($sales->discount)?$sales->discount:'0.00') ?>">
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="thStyleNew">Net Total</th>
                                    <th class="tdStyleNew">
                                        <input tabindex="-1" id="totalAmount" value='<?php echo (!empty($sales->net_total)?$sales->net_total:'0.00'); ?>' type="text"
                                               class="form-control inputStyle"
                                               readonly=""
                                               name="totalAmount"
                                        >
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2" class="tdStyleNew">
                                        <?php
                                            $paymentBy=(!empty($sales->payment_by)?json_decode($sales->payment_by,true):'');
                                        ?>
                                        <table class="table table-bordered">
                                            <tr>
                                                <td rowspan="4"  class="paymentBy"> Payment By </td>
                                                <td>
                                                    <label class="radio-inline"> <input type="checkbox" tabindex="-1"  id="cash"
                                                                                        value="cash"
                                                                                        onchange="isCheckedById(this)"
                                                            <?php echo (!empty($paymentBy['cash'])?'checked':'0') ?>
                                                                                        name="payment_by[0]"
                                                        ></label>
                                                </td>
                                                <td>
                                                    Cash
                                                </td>

                                                <td>
                                                    <input type="text" placeholder="0.00"   id="cash_amount" value="<?php echo (!empty($paymentBy['cash'])?$paymentBy['cash']:'0') ?>"
                                                           name="payment_ctg_amount[]"
                                                           class="form-control payment_ctg_amount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio-inline"> <input type="checkbox" tabindex="-1" id="cash_cheque"
                                                                                        onchange="isCheckedById(this)"
                                                                                        value="cash_cheque"
                                                                                        name="payment_by[1]"  <?php echo (!empty($paymentBy['cash_cheque'])?'checked':'') ?>
                                                        ></label>
                                                </td>
                                                <td>
                                                    Cash cheque
                                                </td>

                                                <td>
                                                    <input type="text" tabindex="-1" placeholder="0.00"  readonly
                                                           id="cash_cheque_amount"
                                                           name="payment_ctg_amount[]" value="<?php echo (!empty($paymentBy['cash_cheque'])?$paymentBy['cash_cheque']:'0') ?>"
                                                           class="form-control payment_ctg_amount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio-inline"> <input type="checkbox" tabindex="-1" id="due_cheque"
                                                                                        onclick="isCheckedById(this)"
                                                                                        value="due_cheque" tabindex="-1"  <?php echo (!empty($paymentBy['due_cheque'])?'checked':'') ?>
                                                                                        name="payment_by[2]"
                                                        ></label>
                                                </td>
                                                <td>
                                                    Due cheque
                                                </td>

                                                <td>
                                                    <input type="text" tabindex="-1" placeholder="0.00"   id="due_cheque_amount"
                                                           name="payment_ctg_amount[]" value="<?php echo (!empty($paymentBy['due_cheque'])?$paymentBy['due_cheque']:'0') ?>" tabindex="-1" readonly
                                                           class="form-control payment_ctg_amount">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="radio-inline"> <input type="checkbox" tabindex="-1" id="online"
                                                                                        onclick="isCheckedById(this)"
                                                                                        value="online_payment" tabindex="-1"
                                                                                        name="payment_by[3]"  <?php echo (!empty($paymentBy['online_payment'])?'checked':'') ?>
                                                        ></label>
                                                </td>
                                                <td>
                                                    Online Payment
                                                </td>

                                                <td>
                                                    <input placeholder="0.00"  tabindex="-1" type="text"  id="online_amount" value="<?php echo (!empty($paymentBy['online_payment'])?$paymentBy['online_payment']:'0') ?>" readonly
                                                           name="payment_ctg_amount[]"
                                                           class="form-control payment_ctg_amount">
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                                <tr>

                                    <th class="thStyleNew"  style="color:blue;">Payment </th>
                                    <th class="tdStyleNew">
                                        <input  id="paidNow"  tabindex="-1" placeholder="0.00" value='<?php echo (!empty($sales->payment_amount)?$sales->payment_amount:'0.00'); ?>'  type="text"
                                                class="form-control inputStyle"  name="paidNow" style='border:1px solid blue;' >
                                    </th>
                                </tr>
                                <tr>

                                    <th class="thStyleNew" >Current Due </th>
                                    <th class="tdStyleNew">
                                        <input tabindex="-1" id="currentDueAmount" placeholder="0.00" value='<?php echo (!empty($sales->current_due_amt)?$sales->current_due_amt:'0.00'); ?>'  type="text"
                                               class="form-control inputStyle" readonly  name="currentDueAmount" >
                                    </th>
                                </tr>
                                <tr>

                                    <th class="thStyleNew" >Previous Due </th>
                                    <th class="tdStyleNew">
                                        <input tabindex="-1" id="customerPreviousDue" placeholder="0.00"
                                               value="<?php echo (!empty($sales->previous_due)?$sales->previous_due:'0.00'); ?>"
                                               type="text"
                                               class="form-control inputStyle" readonly  name="customerPreviousDue" >
                                    </th>
                                </tr>
                                <tr>
                                    <th class="thStyleNew">Total Due </th>
                                    <th class="tdStyleNew">
                                        <input tabindex="-1" id="totalCustomerDue" readonly placeholder="0.00" value='<?php echo (!empty($sales->total_due)?$sales->total_due:'0.00'); ?>'   type="text"  class="form-control inputStyle"  name="totalCustomerDue" >
                                    </th>
                                </tr>
                                <tr>
                                    <th class="thStyleNew"> </th>
                                    <th class="thStyleNew"  >
                                        <label class="radio-inline"> <input type="checkbox"  id="isRemainingDueMakesWithDiscount" value="1" tabindex="-1" name="isRemainingDueMakesWithDiscount" ><b> Remaining Due Make as  Discount </b></label>
                                    </th>

                                </tr>


                                <tr id="div5">
                                    <th colspan="4">
                                        <button type="button" id="confirmModal" class="btn btn-block btn-success"   >SALES NOW </button>
                                        <input type="hidden" value="<?php echo (!empty($sales->id)?sha1($sales->id):''); ?>" name="upId" id="upId">
                                        <input type="hidden" value="<?php echo (!empty($sales->id)?$sales->id:''); ?>" name="updatedID" id="updatedID">

                                    </th>
                                </tr>
                                <tr id="div5">
                                    <td colspan="4">

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal fade" id="salesConfirmModal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" tabindex="-1" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Sales Order Confirmation</h4>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width:50%;">Customer Name</th>
                                            <td><span id="showConfirmName"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Net Total</th>
                                            <td><span id="showNetTotal"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Payment Amount</th>
                                            <td><span id="showPaymentAmount"></span></td>
                                        </tr>
                                        <tr>
                                            <th>Current Due Amount</th>
                                            <td><span id="showCurrentDueAmount"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Previous Due Amount</th>
                                            <td><span id="showPreviousDueAmount"></span></td>
                                        </tr>

                                        <tr>
                                            <th>Total Due Amount</th>
                                            <td><span id="showTotalDueAmount"></span></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12">
                                    <div style="color: red;font-weight: bold;padding-bottom:5px"  id="show_error_save_main"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="modal-footer">
                                    <div class="clearfix"></div>
                                    <button name="submitBtn" onclick="saveSalesInfo()" type="button"
                                            id="payment_genarel"
                                            class="btn btn-success subBtn"
                                    ><i class="glyphicon glyphicon-ok-circle "></i> CONFIRM SALES
                                    </button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                            class="glyphicon glyphicon-remove "></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>
        </form>
    </div>
</div>
<div class="modal fade" id="CustomerInfoModal" role="dialog">
    <div class="modal-dialog">
        <form action="" method="post" id="customerMemberInfoForm" class="form-horizontal" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add New Customer Information</h4>
                </div>
                <div class="modal-body">
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Name
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" required name="name" placeholder=" Name" id="name">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Mobile
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="mobile" placeholder=" Mobile" id="mobile">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Email
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="email" placeholder="Email" id="email">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Address
                        </label>
                        <div class="col-sm-9">
                                                    <textarea class="form-control" name="address" placeholder="Address"
                                                              id="address"></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Date of Birth
                        </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control datepicker"
                                   name="customer_date_of_birth" value="<?php echo date('d-m-Y') ?>"
                                   placeholder="Date of
                                       Births"
                                   id="customer_date_of_birth">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Remarks
                        </label>
                        <div class="col-sm-9">
                                                    <textarea class="form-control" name="remarks" placeholder="Remarks"
                                                              id="remarks"></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="col-sm-3 text-right">
                            Status
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>

                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="col-sm-12 text-left">
                        <div class="box-body" id="alert_error" style="display: none;"> <div class="callout
                                                callout-danger"><span id="show_error_save"></span></div></div>
                    </div>
                    <div class="col-sm-12">
                        <input type="hidden" value="<?php echo $this->outletID; ?>"
                               name="outlet_id"
                               id="outlet_id" >
                        <input type="hidden" name="upId" id="upId" >
                        <input type="hidden" value="<?php  echo 1 ?>" name="type"   id="type" >
                        <input type="hidden" value="<?php  echo (!empty($redierct_page)?$redierct_page:'') ?>" name="redierct_page" id="redierct_page" >
                        <button type="button" onclick="saveCustomerMemberInfoPos()" name="saveBtn" id="saveBtn"
                                class="btn
                                                        btn-success submit_btn"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon
                                                glyphicon-remove"></i> Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
include ('salesFooter.php');
?>
