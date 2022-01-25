<!-- Content Header (Page header) -->
<section class="content-header">
  <?php if($this->session->flashdata('msg')){?>
  <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('msg'); ?>
  </div>
  <?php }?>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">New Transfer</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo site_url('transfers/store'); ?>" method="POST" role="form">
            <input type="hidden" name="selectedFromWareHouse" id="selectedFromWareHouse">
            <input type="hidden" name="selectedToWareHouse" id="selectedToWareHouse">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">                            
                            <div class="form-group">
                                <label>Transfer Date<sup>*</sup></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input name="transferDate" id="datepicker" class="form-control" placeholder="YYYY-MM-DD"> <!-- For Limit Today:  data-provide="datepicker" data-date-end-date="0d" -->
                                </div><!-- /.input group -->
                                <!--<p style="color: red; text-align: center; font-size: 12px;">
                                    Will not be greater than today
                                </p>-->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Transfer No.</label>
                                <input name="transferNo" id="transferNo" type="text" readonly  class="form-control">
                            </div>                           
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>From Warehouse<sup>*</sup></label>
                                <select id="fromWarehouseID" class="form-control select2" style="width: 100%;">
                                  <option value="">Select Warehouse</option>
                                  <?php foreach($warehouses as $warehouse){ ?>
                                  <option value="<?php echo $warehouse->warehouseID; ?>"><?php echo $warehouse->warehouseName; ?></option>
                                  <?php } ?>
                                </select>
                            </div>                           
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>To Warehouse<sup>*</sup></label>
                                <select id="toWarehouseID" class="form-control select2" style="width: 100%;">
                                  
                                </select>
                            </div>                           
                        </div>

                        
                        
                    </div> 

                    <div class="row">
                        <div class="col-md-2"><label>Select Product</label></div>
                        <div class="col-md-8">
                            <input type="hidden" id="selectedProductID">
                            <select class="productID form-control select2" style="width: 100%;"></select>
                        </div>
                        <div class="col-md-2"><a href="javascript:void(0);" id="addRow" class="btn btn-info btn-flat btn-sm">Add Product</a></div>
                    </div>
                    

                    <div class="box-header">
                        <h3 class="box-title">Products *</h3>
                    </div><!-- /.box-header -->
                    <div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">Sl.</th>
                                    <th>Product Name</th>
                                    <th style="width: 20%;">Available Quantity</th>
                                    <th style="width: 20%;">Quantity</th>
                                    <th style="width: 6%;">#</th>
                                </tr>
                            </thead>
                            <tbody id="tableDynamic">
                                

                            </tbody>
                        </table>
                        <table class="table">
                            <tr>
                                <td style="width: 66%;border-top: medium none;"></td>
                                <td style="width: 15%;border-top: medium none; text-align: right;" colspan=""></td>
                                <td style="border-top: medium none;"></td>
                            </tr>
                            <tr>
                                <td rowspan="5" style="border-top: medium none;">
                                    <label for="">Note<sup>*</sup></label>
                                    <textarea class="textarea" name="note"  placeholder="Note" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                                </td>
                            </tr>
                            
                            <tr>

                                <td style="border-top: medium none; text-align: right;" colspan=""></td>
                                <td style="border-top: medium none;"></td>
                            </tr>


                            <tr>
                                <td style="border-top: medium none; text-align: right;" colspan=""></td>
                                <td style="border-top: medium none;"></td>
                            </tr>                    
                            <tr>
                                <td style="border-top: medium none; text-align: right;" colspan=""></td>
                                <td style="border-top: medium none;"></td>
                            </tr>
                        </table>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" id="submitBTN" class="btn btn-primary btn-flat"  onclick="return checkadd();">Create Transfer</button>
                    <a href="<?php echo base_url('transfers/create'); ?>" class="btn btn-danger btn-flat" >Reset</a>
                </div>
            </form>
        </div>
    </div>  
</div>

</section>
<!-- /.content -->


<script type="text/javascript">

    var today = new Date();  
    var dd = today.getDate();  
      
    var mm = today.getMonth()+1;   
    var yyyy = today.getFullYear();  
    if(dd<10)   
    {  
        dd='0'+dd;  
    }   
      
    if(mm<10)   
    {  
        mm='0'+mm;  
    }   
    today = yyyy+'-'+mm+'-'+dd;  
    $("#datepicker").val(today);
    $("#datepicker2").val(today);

    $(function() {
        $("#transferNo").val('TRAN-'+randomString(3));
    });

    // Random String Function
    var randomString = function(length) {
        var text = "";
        var possible = "0123456789";
        for(var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    };

    $( "#fromWarehouseID" ).change(function() {
      var fromWarehouseID = this.value;
      if (!isNaN(fromWarehouseID)) {
        //console.log(toWarehouseID);
        $.get( "<?php echo base_url('transfers/askWarehouses'); ?>", function( data ) {
            //console.log($.parseJSON(data));
            $('#toWarehouseID').find('option').remove().end();
            $('#toWarehouseID').append('<option>Select Warehouse</option>');

            var warehouse = $.parseJSON(data);
            
            for (var i = 0; i < warehouse.length; i++) {
                if(warehouse[i].warehouseID != fromWarehouseID){
                    var opt = $('<option />'); // here we're creating a new select option for each group
                    opt.val(warehouse[i].warehouseID);
                    opt.text(warehouse[i].warehouseName);
                    $('#toWarehouseID').append(opt);

                }
            }

        });
      }else{
        $('#toWarehouseID').find('option').remove().end();
      }
    });

    $( "#toWarehouseID" ).change(function() {
      var toWarehouseID = this.value;
      var fromWarehouseID = $('#fromWarehouseID').val();
      if (!isNaN(toWarehouseID)) {
        //console.log($('#fromWarehouseID').val());
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('transfers/askInventory'); ?>",
            data: 'warehouse=' + fromWarehouseID,
            dataType: 'json',
            success: function (data) {
                $('.productID').find('option').remove().end();
                $('.productID').append('<option>Select Product</option>');
                $('.select2').select2();
                for (var i = 0; i < data.length; i++) {
                    var inventory = data[i].inventory;
                    //console.log(data[i].inventory);
                    for (var j = 0; j < inventory.length; j++) {

                        //console.log(inventory[j].productName);
                        var opt = $('<option />'); // here we're creating a new select option for each group
                        opt.val(inventory[j].productID);
                        opt.text(inventory[j].productName+' '+'('+inventory[j].productCode+')');
                        $('.productID').append(opt);
                    }
                }
            }
        });
      }else{
        
      }
    });

    $('.productID').on('change', function (e) {
        
        var valueSelected = this.value;
        $('#selectedProductID').val(valueSelected);
        
    });

    var scntDiv = $('#tableDynamic');
    var i = $('#tableDynamic tr').size();

    
    
    $('#addRow').on('click', function () {
        var fromWarehouseID = $('#fromWarehouseID').val();
        var selectedProductID = $('#selectedProductID').val();
        if(selectedProductID){
        $('#selectedFromWareHouse').val($('#fromWarehouseID').val());
        $('#selectedToWareHouse').val($('#toWarehouseID').val());
        
        $('#fromWarehouseID').prop('disabled', 'disabled');
        $('#toWarehouseID').prop('disabled', 'disabled');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('transfers/askInventory'); ?>",
            data: 'warehouse=' + fromWarehouseID + '&productID=' + selectedProductID,
            dataType: 'json',
            success: function (data) {
                //console.log(data[0].inventory[0]);
                $('<tr>\n\
                    <td>' + i + '</td>\n\
                    <td>\n\
                        <input value="'+data[0].inventory[0].productID+'" type="hidden" readonly name="productID[]" id="productName_' + i + '"  placeholder="Product Name" class="form-control">\n\
                        <input value="'+data[0].inventory[0].productName+' ('+data[0].inventory[0].productCode+')"  type="text" readonly id="productName_' + i + '"  placeholder="Product Name" class="form-control">\n\
                    </td>\n\
                    <td>\n\
                        <input value="'+data[0].inventory[0].inventory+'"  type="text" readonly name="availableQuantity[]" id="availableQuantity_' + i + '"  placeholder="Quantity" class="form-control">\n\
                    </td>\n\
                    <td>\n\
                        <input type="text" name="quantity[]" id="quantity_' + i + '"  placeholder="Quantity" class="quant form-control">\n\
                    </td>\n\
                    <td>\n\
                        <a href="javascript:void(0);" id="deleteRow_' + i + '"  class="deleteRow btn btn-danger btn-flat btn-sm">Delete</a>\n\
                    </td>\n\
                </tr>').appendTo(scntDiv);
            }
        });
      

        

        i++;



        return false;
        }
    });


    $(document).on("click", ".deleteRow", function (e) {
        //if ($('#tableDynamic tr').size() > 1) {
            var target = e.target;

            $(target).closest('tr').remove();


        //} else {
            //alert('One row should be present in table');
        //}
    });


    $(document).on("keyup", ".quant", function (event) {
        var id_arr = $(this).attr('id');
        var id = id_arr.split("_");
        var element_id = id[id.length - 1];
        var quantity = parseInt($(this).val());
        var available = parseInt($('#availableQuantity_'+element_id).val());
        
        if(quantity > available){
            $('#submitBTN').prop('disabled', 'disabled');
            $( this ).css( "border", "2px solid red" );
        }else{
           $( this ).css( "border", "1px solid #ddd" );
           $('#submitBTN'). removeAttr("disabled"); 
        }
    });

    function checkadd() {
        if($('#tableDynamic tr').size() > 0){
            var chk = confirm("Are you sure to add this record ?");
            if (chk) {
                return true;
            } else {
                return false;
            }
            ;
        }else{
            alert('Choose some product to Transfer!!!');
            return false;
        }
    }


</script>


