<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                                id="show_message"></span></div></div>
                <div class="box-header">
                    <h3 class="box-title pull-left"><?php echo !empty($title)?$title:'' ?></h3>
                    <?php if ($this->session->flashdata('msg')) { ?>

                        <?php echo $this->session->flashdata('msg'); ?>

                    <?php } ?>
                    <h3 class="box-title pull-right" style="padding-right:10px;"><a class="btn btn-success btn-sm"   href="<?php echo site_url('UserAccessRole/userAccessCreate') ?>"><i class="glyphicon glyphicon-plus"></i> Add</a></h3>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="width10per">SL</th>
                            <th>Role Name </th>
                            <th>Status </th>
                            <th class="width20per"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $si = 1;
                        if(!empty($all_acl_menu_info)) {
                            foreach ($all_acl_menu_info as $row) {
                                ?>
                                <tr>
                                    <td class="vertical-align-middle"><?php echo $si; ?></td>
                                    <td class="vertical-align-middle"><?php echo $row->role_name; ?></td>
                                    <td class="vertical-align-middle"><?php echo (!empty($row->is_active) && $row->is_active==1)?"Active":"InActive" ; ?></td>

                                    <td class="vertical-align-middle text-center">

                                        <a class="btn btn-info btn-xs" href="<?php echo site_url('UserAccessRole/userAccessEdit/'.$row->id) ?>"><i class="glyphicon
                                    glyphicon-pencil"></i> Edit</a>
                                    </td>
                                </tr>
                                <?php
                                $si++;
                            }
                        }
                        ?>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>









