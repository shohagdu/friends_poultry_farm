<?php
extract($_POST);
?>
<style>
    #example1 td,th{
        font-size:12px !important;
        padding-left:2px;
        padding-right:2px;
    }
</style>


<section class="content">
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Club Member Information</h3>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-sm-offset-2 col-xs-4">
                                <label>From Member code (Exp.0001)</label>
                                <input type="text"  placeholder="Mr. X Or 1235"    value=" <?php  if(isset($clientid) && ($clientid!='')){echo $clientid; }?>"   name="clientid" class="form-control">
                            </div>
                            <div class=" col-xs-4">
                                <label>To Member code (Exp.0100)</label>
                                <input type="text"   class="form-control" value=" <?php  if(isset($clientid_end) && ($clientid_end!='')){echo $clientid_end; }?>"  name="clientid_end" >
                            </div>


                            <!-- /.col -->
                            <div class="col-xs-1">
                                <div class="form-group has-feedback">
                                    <button type="submit" name="searchBtn" class="btn btn-success btn-sm"><i
                                            class="glyphicon glyphicon-search"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-5" >

                                <?php if ($this->session->flashdata('msg')) {
                                    echo $this->session->flashdata('msg');
                                } ?>
                                <?php if ($this->session->flashdata('usingTransaction')) {
                                    echo $this->session->flashdata('usingTransaction');
                                } ?>
                            </div>

                            <!-- /.col -->
                        </div>
                    </form>
                    <?php
                    if(isset($_POST['searchBtn']) || isset($_POST['updateBtn'])){
                        ?>
                        <table  class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width:5%;">SL.</th>
                                <th>Image</th>
                                <th>Code</th>
                                <th>Passowrd</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Dept</th>
                                <th>Subs. Ctg</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th style="width:15%;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl = 1;
                            //                        echo "<pre>";
                            //                        print_r($view_member);
                            foreach ($view_member as $member) { ?>
                                <tr>
                                    <td><?php echo $sl; ?></td>
                                    <td><img src="<?php if(file_exists($member->member_image)){ echo base_url().$member->member_image;}else{ echo  base_url().'assets/image/default/default.png';} ?>" style="height: 50px;width:60px;"></td>
                                    <td><?php echo $member->member_code; ?></td>
                                    <td><?php echo $member->password; ?></td>
                                    <td><?php echo $member->name; ?></td>
                                    <td><?php echo $member->designationTitle; ?></td>
                                    <td><?php echo $member->deptTitle; ?></td>
                                    <td><?php echo $member->sub_ctg_title."(".$member->sub_amount.")"; ?></td>
                                    <td><?php echo $member->mobile; ?></td>
                                    <td><?php echo $member->email; ?></td>
                                    <td><?php echo ($member->is_active==1)?"<b style='color:green'>Active</b>":"<b style='color:red;'>Inactive</b>"; ?></td>
                                    <td>


                                        <button class="btn btn-info btn-xs"
                                                onclick="viewInfo('<?php echo $member->id; ?>','<?php echo $member->member_code; ?>','<?php echo $member->name; ?>','<?php echo $member->mobile; ?>','<?php echo $member->email; ?>','<?php echo $member->is_active; ?>','<?php echo $member->dept; ?>','<?php echo $member->designation; ?>','<?php echo ($member->member_image!='')?base_url().$member->member_image:base_url().'assets/image/default/default.png'; ?>','<?php echo $member->member_image; ?>','<?php echo $member->subscription_ctg_id; ?>')"
                                                data-toggle="modal" data-target="#myModal"><i
                                                class="glyphicon glyphicon-pencil"></i> Update
                                        </button>

                                    </td>

                                </tr>
                                <?php $sl++; ?>
                            <?php } ?>
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    <?php } ?>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
</section>
<script>
    $( document ).ready(function() {
        $("#existing_code").hide();
        $("#clientid_search").focus();
        $('#clientid_search').val('');
    });
    $("#clientid_search").autocomplete({
        source: "<?php echo site_url('pos/getcustomername'); ?>",
        select: function(event, ui) {
            console.log(ui);
            $("#clientid").val(ui.item.id);
            $("#clientid_search").val(ui.item.value);
            return false;
        }
    });
    $("#clientid_search_end").autocomplete({
        source: "<?php echo site_url('pos/getcustomername'); ?>",
        select: function(event, ui) {
            console.log(ui);
            $("#clientid_end").val(ui.item.id);
            $("#clientid_search_end").val(ui.item.value);
            return false;
        }
    });


    function viewInfo(id, code,name,mobile,email,status,dept,designation,image,hidden_image,subs_ctg) {

        $('#img_id').attr('src',image);
        $("#hidden_image").val(hidden_image);
        $("#code").val(code);
        $("#name").val(name);
        $("#mobile").val(mobile);
        $("#email").val(email);
        $("#status").val(status);
        $("#department").val(dept);
        $("#designation").val(designation);
        $("#subs_ctg").val(subs_ctg);

        $("#clientidUpdate").val($("#clientid").val());
        $("#clientid_endUpdate").val($("#clientid_end").val());

        $("#upId").val(id);
        $("#saveBtn").hide();
        $("#updateBtn").show();
    }
    function changePassword(id, code,name,password) {
        $("#pass_code").val(code);
        $("#pass_name").val(name);
        $("#new_password").val(password);
        $("#new_upId").val(id);
    }

    function addData() {
        $("#add_title").val('');
        $("#code").val('');
        $("#name").val('');
        $("#mobile").val('');
        $("#email").val('');
        $("#department").val('');
        $("#designation").val('');
        $("#upId").val('');
        $("#updateBtn").hide();
        $("#saveBtn").show();
    }
    function checkCodeDuplicate(code){
        var update_id= $("#upId").val();
        $.ajax({
            url: "<?php echo site_url('settings/checkCodeDuplicate'); ?>",
            type: "post",
            data: {memberCode:code,update_id:update_id}  ,
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                // condsole.log(response);
                if(response=='existing_code'){
                    $("#existing_code").show();
                    $("#code").val('');
                }else{
                    $("#existing_code").hide();

                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }


        });
    }

</script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Member Information</h4>
                </div>
                <div class="modal-body">
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Code
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required onkeyup="checkCodeDuplicate(this.value)" name="code" placeholder="Member Code" id="code">
                        </div>
                        <div class="col-sm-2">
                            <div class="row" style="padding-top:5px;">
                                <span id="existing_code" style="color:red;" >Code is used</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Name
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required name="name" placeholder="Member Name" id="name">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Designation
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control" name="designation" id="designation">
                                <option value="">Select Designation</option>
                                <?php foreach ($view_designation as $desination) { ?>
                                    <option value="<?php echo $desination->id ?>"><?php echo $desination->title ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Department
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control" name="department" id="department">
                                <option value="">Select Department</option>
                                <?php foreach ($view_dapartment as $department) { ?>
                                    <option value="<?php echo $department->id ?>"><?php echo $department->title ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Subscription Ctg
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control" name="subs_ctg" id="subs_ctg">
                                <option value="">Select Subscription Category</option>
                                <?php foreach ($subscription_ctg as $subs_ctg) { ?>
                                    <option value="<?php echo $subs_ctg->id ?>"><?php echo $subs_ctg->title."(".$subs_ctg->amount.")"; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Mobile
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="mobile" placeholder="Member Mobile" id="mobile">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Email
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="email" placeholder="Member Email" id="email">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Status
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">Image</div>
                        <div class="col-sm-8">
                            <input  id="membertImage" type="file" name="membertImage"
                                    class="form-control" accept="image/jpeg, image/jpg, image/png"  onchange="LoadFile(event);">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="col-sm-12"  id="img_div">
                                <img src="<?php echo base_url();?>assets/image/default/default.png "  style="height:140px;width:200px;border:1px solid #d0d0d0;"   id="img_id"/>
                                <input type="hidden" name="hidden_image" id="hidden_image" >

                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>



                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="col-sm-2 text-right">

                        </div>
                        <div class="col-sm-8">
                            <input type="hidden" name="upId" id="upId">
                            <input type="hidden" name="clientid" id="clientidUpdate">
                            <input type="hidden" name="clientid_end" id="clientid_endUpdate">
                            <input type="submit" name="saveBtn" id="saveBtn" class="btn btn-success btn-sm"
                                   value="Save">
                            <input type="submit" name="updateBtn" id="updateBtn" class="btn btn-success btn-sm"
                                   value="Update">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<div class="modal fade" id="myModalChangePass" role="dialog">
    <div class="modal-dialog">

        <form action="<?php  echo site_url('settings/changePassoword');?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Code
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"  readonly name="pass_code" placeholder="Member Code" id="pass_code">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Name
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" readonly required name="pass_name" placeholder="Member Name" id="pass_name">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Password
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control"  name="new_password" placeholder="Enter New Password" id="new_password">
                        </div>
                    </div>




                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="col-sm-2 text-right">

                        </div>
                        <div class="col-sm-8">
                            <input type="hidden" name="upId" id="upId">
                            <input type="submit" name="saveBtnChange" id="saveBtnChange" class="btn btn-success btn-sm"
                                   value="Change Password">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="hidden" name="new_upId" id="new_upId">
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    var LoadFile=function(event){
        var output=document.getElementById("img_id");
        document.getElementById("img_div").style.display = "block";
        output.src=URL.createObjectURL(event.target.files[0]);

    }
</script>



<!-- /.content -->