
<!-- Main content -->
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">User Info</h3>
            <?php if ($this->session->flashdata('msg')) { ?>
                <?php echo $this->session->flashdata('msg'); ?>
            <?php } ?>
            <a href="<?php echo site_url('settings/addUser'); ?>"
               class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>S/L</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i=1;
                if(!empty($admin_list)){
                    foreach ($admin_list as $each_admin) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $each_admin->username; ?></td>
                            <td><?php echo $each_admin->email; ?></td>
                            <td>
                                <?php echo $each_admin->role_name  ?>
                            </td>
                            <td>
                                <span class="badge <?php echo (!empty($each_admin->status) && $each_admin->status=='Active')?'bg-green-active':'bg-red-active' ?>  "> <?php echo $each_admin->status  ?></span>
                            </td>


                            <td>
                                <a style="margin-right: 5px;" href="<?php echo base_url('settings/editadmin'); ?>/<?php echo $each_admin->userID; ?>" class="btn btn-primary btn-sm pull-left"><i class="glyphicon glyphicon-pencil"></i> Update</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                ?>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
<!-- /.content -->