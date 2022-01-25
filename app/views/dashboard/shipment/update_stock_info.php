<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span    id="show_message"></span></div></div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('msg'); ?>
                        </div>
                    <?php } ?>
                    <a href="<?php echo site_url('shipment_info/stock_info'); ?>" class="btn btn-primary  pull-right" title="View"><i class="glyphicon glyphicon-list"></i> view</a>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form action="" method="POST" id="stockInInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Shipment</label>
                                    <select id="shipmentID" name="shipmentID" class="form-control" required style="width: 100%;">
                                        <option value="">Select Shipment </option>
                                        <?php if(!empty($shipment_info)){ foreach ($shipment_info as $shipment) { ?>
                                            <option value="<?php echo $shipment->id; ?>" <?php echo ((!empty
                                            ($shipment_details_info->shipment_id) &&
                                            $shipment_details_info->shipment_id==$shipment->id)?"selected":'') ?>><?php
                                                echo
                                            $shipment->title;
                                                ?></option>
                                        <?php } }?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input name="trans_date" id="trans_date" class="form-control datepicker"
                                               placeholder="DD-MM-YYYY" value="<?php echo ((!empty
                                            ($shipment_details_info->destibute_dt))
                                            ?date('d-m-Y',strtotime($shipment_details_info->destibute_dt)):'') ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Note</label>
                                    <textarea name="note" rows="1" id="note" type="text" placeholder="Enter Note..  .."  class="form-control"><?php echo ((!empty($shipment_details_info->note))?$shipment_details_info->note:'') ?></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div>
                            <table class="table-style-main" class="table table-striped" style="border:1px solid #d0d0d0;">
                                <thead>
                                <tr>
                                    <th colspan="8"> Shipment Product Information </th>
                                </tr>
                                <tr>
                                    <th style="width: 3%;">SL</th>
                                    <th style="width: 20%;">Member Name</th>
                                    <th >Cartt Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Sub Total</th>
                                    <th>Discount</th>
                                    <th>Net Bill</th>
                                    <th style="width: 6%;">#</th>
                                </tr>
                                </thead>
                                <tbody id="tableDynamicShipment">
                                <?php
                                    $tDebitAmt='0.00';
                                    $i=1;
                                    if(!empty($shipment_details_info->shipment_details)){
                                        foreach($shipment_details_info->shipment_details as $row){
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td>
                                                    <input type="text" value="<?php echo (!empty($row->member_name)
                                                        ?$row->member_name." (".$row->mobile.")-".$row->address:'') ?>"
                                                           id="member_name_<?php echo
                                                    (!empty($row->id)
                                                        ?$row->id:'') ?>" required data-type="memberid"
                                                           placeholder="Member Name" class="memberName form-control">
                                                    <input type="hidden" name="memberID[]" value="<?php echo (!empty
                                                    ($row->member_id)?$row->member_id:'') ?>" id="memberid_<?php echo
                                                    (!empty($row->id)?$row->id:'') ?>" class="form-control">
                                                    <input type="hidden" name="stock_id[]" value="<?php echo (!empty
                                                    ($row->id)?$row->id:'') ?>" id="stock_id_<?php echo
                                                    (!empty($row->id)?$row->id:'') ?>" class="form-control">

                                                </td>
                                                <td><input type="text" required name="quantity[]" id="quantity_<?php echo (!empty($row->id)?$row->id:'') ?>"
                                                           value="<?php echo (!empty($row->debit_qty)?$row->debit_qty:'') ?>"
                                                           placeholder="Quantity" class="quant form-control only-number"></td>
                                                <td><input type="text" required name="unit_price[]" value="<?php echo (!empty($row->unit_price)?$row->unit_price:'') ?>"
                                                           id="unit_price_<?php echo (!empty($row->id)?$row->id:'') ?>"  placeholder="Unit Price" class="unit_price form-control only-number"></td>
                                                <td><input type="text" required name="sub_price[]" readonly id="sub_price_<?php echo (!empty($row->id)?$row->id:'') ?>"
                                                           placeholder="0.00" value="<?php echo (!empty($row->sub_total)?$row->sub_total:'') ?>" class="form-control only-number"></td>
                                                <td><input type="text" required name="discount_price[]"
                                                           id="discount_price_<?php echo (!empty($row->id)?$row->id:'') ?>"   placeholder="0.00" value="<?php echo (!empty($row->discount)?$row->discount:'') ?>" class="discount_price form-control only-number"></td>
                                                <td><input type="text" required name="net_total[]" value="<?php echo (!empty($row->debit_amount)?$row->debit_amount:'') ?>"  readonly
                                                           id="net_total_<?php echo (!empty($row->id)?$row->id:'') ?>"
                                                           placeholder="0.00" class="net_total form-control only-number"></td>
                                                <td><a href="javascript:void(0);" id="deleteRow_<?php echo (!empty
                                                    ($row->id)?$row->id:'') ?>"  class="deleteRowShipment btn
                                                    btn-danger  btn-sm"><i class="glyphicon glyphicon-remove"></i></a></td>
                                            </tr>

                                <?php
                                            $tDebitAmt+=$row->debit_amount;
                                        }
                                    }
                                ?>

                                </tbody>
                                <tfoot>
                                <tr >
                                    <td colspan="5"><a href="javascript:void(0);" id="addRowStockInShipment" class="btn
                                    btn-info btn-flat btn-sm"><i class="glyphicon glyphicon-plus"></i> Add
                                            Member</a></td>
                                    <th class="text-right">Total Amount</th>
                                    <td colspan="2"><input type="text" readonly required name="total_amount"
                                                           value="<?php echo (!empty($tDebitAmt)?number_format
                                                           ($tDebitAmt,2,'.',''):'0.00') ?>"
                                                           id="total_amount"
                                                           placeholder="0.00" class="form-control only-number"></td>
                                </tr>
                                </tfoot>

                            </table>


                        </div>

                    </div>

                    <div class="box-footer text-right">
                        <div class="col-sm-6 text-left">
                            <div id="show_error_save"></div>
                        </div>
                        <div class="col-sm-6">
                            <input type="hidden" name="update_id" value="<?php echo (!empty($shipment_details_info->id)
                                ?$shipment_details_info->id:'') ?>">
                            <button type="button" id="submit_btn"  class="btn btn-success btn-flat submit_btn"
                                    onclick="saveShipmentStockInfo()"><i class="glyphicon glyphicon-ok-sign"></i>
                                Update Stock In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>



