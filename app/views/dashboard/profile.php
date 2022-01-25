<?php
$user = $this->session->userdata('user');
$admin_data = $this->COMMON_MODEL->get_single_data_by_single_column('tbl_pos_users', 'userID', $user);
?>
<section class="content">
    <section class="invoice">
        <div class="row">
            <div class="col-xs-3"></div>
            <div class="col-xs-6">
                <h2 class="page-header">
                    Profile
                    <small class="pull-right" id="today"></small>
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-3"></div>
            <div class="col-xs-6 table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td><?php echo $admin_data['username']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $admin_data['email']; ?></td>
                        </tr>

                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <?php
                $messages = $this->session->userdata('messages');
                if (isset($messages) || !empty($messages)):
                    ?>
                    <div class="alert alert-success fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-check"></i> <?php echo $messages; ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('messages');
                endif;
                ?>
                <?php
                $errors = $this->session->userdata('errors');
                if (isset($errors) || !empty($errors)):
                    ?>
                    <div class="alert alert-danger fade in widget-inner">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-check"></i> <?php echo $errors; ?>
                    </div>
                    <?php
                    $this->session->unset_userdata('errors');
                endif;
                ?>
                <form action="" method="post">
                    <div class="form-group has-feedback">
                        <label>Old Password</label>
                        <input type="hidden" name="admin_ids" value="<?php echo $admin_data['userID'] ?>">
                        <input type="password" required=""  name="old_password" class="form-control " placeholder="Type Old Password">
                    </div>
                    <div class="form-group has-feedback">
                        <label>New Password</label>
                        <input required="" type="password"  name="new_password" class="form-control " placeholder="Type New Password">
                    </div>
                    <div class="form-group has-feedback">

                        <button type="submit" name="subtn" class="btn btn-primary btn-block btn-flat">Save</button>

                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3"></div>
            <div class="col-xs-6 table-responsive">
                <div class="box-body">
                    

                </div>
            </div>
        </div>
    </section>
</section>