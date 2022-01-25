

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">New User</h3>
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
                                <input type="name" name="username" class="form-control" placeholder="User Name" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>User Email</label>
                                <input name="email" type="email" class="form-control" placeholder="User Email Address" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control " placeholder="Password" required="">
                            </div>
                            <div class="form-group has-feedback">
                                <label>Outlet</label>
                                <select name="outlet_id" class="form-control select2" required="">
                                    <option value="1">Select Outlet</option>
                                    <?php
                                    if(!empty($outlet_info)){
                                        foreach($outlet_info as $outlet){

                                            ?>
                                            <option value="<?php echo $outlet->id ?>" ><?php echo $outlet->name ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group has-feedback">
                                <label>User Type</label>
                                <select name="roleID" class="form-control select2" required="">
                                    <option value="">Select</option>
                                    <?php
                                    if(!empty($role_info)){
                                        foreach ($role_info as $role ){
                                            echo "<option value='$role->id'>$role->role_name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <button type="submit"  class="btn btn-success btn-sm">Save</button>
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

