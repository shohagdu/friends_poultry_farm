<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit User</h3>
                    <?php if ($this->session->flashdata('msg')) { ?>
                        <?php echo $this->session->flashdata('msg'); ?>
                    <?php } ?>
                    <a href="<?php echo site_url('settings/listUser'); ?>"
                       class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-list"></i> View</a>
                </div>
                <div class="box-body">
                    <div class="col-sm-8">
                        <form action="" method="post">

                            <div class="form-group">
                                <label>User Name</label>
                                <input type="name" name="username" class="form-control" value="<?php echo $edit_admin['username'] ?>" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>User Email</label>
                                <input name="email" type="email" class="form-control" value="<?php echo $edit_admin['email'] ?>" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" >
                            </div>

                            <div class="form-group has-feedback">
                                <label>User Type</label>
                                <select name="roleID" class="form-control select2" required="">
                                    <option value="">Select</option>
                                    <?php
                                    if(!empty($role_info)){
                                        foreach ($role_info as $role ){
                                            $selected = (!empty($edit_admin['roleID']) && ($edit_admin['roleID']==$role->id))?"selected":'';
                                            echo "<option value='$role->id' $selected >$role->role_name</option>";
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Outlet</label>
                                <select name="outlet_id" class="form-control select2" required="">
                                    <option value="1">Select Outlet</option>
                                    <?php
                                    if(!empty($outlet_info)){
                                        foreach($outlet_info as $outlet){
                                            $selected=($outlet->id==$edit_admin['outlet_id'])?"selected":'';
                                            ?>
                                            <option value="<?php echo $outlet->id ?>" <?php echo $selected; ?>><?php echo $outlet->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label>Status</label>
                                <select name="is_active" class="form-control " required="">
                                    <option value="">Select</option>
                                    <option value="1" <?php echo (!empty($edit_admin['is_active']) && ($edit_admin['is_active']==1))?"selected":''; ?>>Active</option>
                                    <option value="2" <?php echo (!empty($edit_admin['is_active']) && ($edit_admin['is_active']==2))?"selected":''; ?>>In Active</option>
                                </select>
                            </div>


                            <div class="row">
                                <div class="col-xs-12 ">
                                    <button type="submit"  class="btn btn-primary  pull-left"><i class="glyphicon glyphicon-ok-sign"></i> Update Now</button>
                                    <a href="<?php echo site_url('settings/listUser'); ?>"  class="btn btn-danger  pull-left" style="margin-left: 10px;"><i class="glyphicon glyphicon-remove"></i> Back</a>

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



