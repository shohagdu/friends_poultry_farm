<section class="content">
    <div class="row">
        <div class="col-md-12">
        <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                    id="show_message"></span></div></div>
        <div class="box">
            <div class="box box-primary">
                <div class="box-header">
                <h3 class="box-title pull-left"><?php echo !empty($title)?$title:'' ?></h3>
                <h3 class="box-title pull-right" style="padding-right:10px;"><a class="btn btn-success btn-sm"   href="<?php echo site_url('UserAccessRole') ?>"><i class="glyphicon glyphicon-list"></i> List</a></h3>
                </div>
                <div class="col-md-8">
                    <form action="<?php echo base_url();?>dashboardcontroller/insert_user_role" id="userRoleForm" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label for="exampleInputPassword1">Role Name <sup>*</sup></label>
                                    <input name="role_name" type="" class="form-control" id="" placeholder="Role Name">
                                </div>

                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group" style="margin-top:20px;">
                                <div class="col-sm-6">
                                        <input type="checkbox" id="checkAll" name="all_check"> <b> All Checked</b>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group" style="margin:15px;">
                                <ul class="sidebar-menu">
                                    <?php

                                        if(!empty($user_menu)){
                                            foreach($user_menu as $main_menu){
                                    ?>
                                    <li>
                                        <input type="checkbox" vlaue="<?php echo $main_menu->id ?>" name="main_menu[<?php echo $main_menu->id ?>]"> <b> <?php echo $main_menu->title ?></b>
                                        <?php
                                            if(!empty($main_menu->all_sub_menu)){
                                        ?>
                                        <ul >
                                        <?php
                                            foreach($main_menu->all_sub_menu as $sub_menu){
                                               // print_r($sub_menu);
                                            if(empty($sub_menu->all_child_menu)){
                                            ?>
                                                <li>
                                                    <input type="checkbox" vlaue="<?php echo $main_menu->id."_".$sub_menu->id ?>"  name="main_menu[<?php echo $main_menu->id ?>][<?php echo $sub_menu->id ?>]"> <?php echo $sub_menu->title ?>
                                            </li>
                                            <?php }else{   ?>
                                                    <li class="treeview">

                                                    <input type="checkbox" vlaue="<?php echo $main_menu->id."_".$sub_menu->id ?>"  name="main_menu[<?php echo $main_menu->id ?>][<?php echo $sub_menu->id ?>]"> <?php echo $sub_menu->title;

                                                    if(!empty($sub_menu->all_child_menu)){
                                                ?>
                                                    <ul >
                                                        <?php
                                                            foreach($sub_menu->all_child_menu as $child_menu){
                                                        ?>
                                                            <li>
                                                                <input vlaue="<?php echo $main_menu->id."_".$sub_menu->id."_".$child_menu->id ?>"  type="checkbox" name="main_menu[<?php echo $main_menu->id ?>][<?php echo $sub_menu->id ?>][<?php echo $child_menu->id ?>]"> <?php echo $child_menu->title ?>

                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>

                                                <?php }  } ?>

                                            <?php }  ?>

                                        </ul>
                                        <?php }  ?>
                                    </li>
                                    <?php } } ?>
                                </ul>
                            </div>
                            <div class="form-group" style="margin-top:5px;">
                                <div id="show_error_save_info" style="color:red;"></div>
                            </div>
                            <div class="form-group" style="margin-top:5px;">
                                <div class="col-sm-12">
                                    <button type="button"  name="submitBtn" onclick="saveUserRole()" class="btn btn-success" ><i class="glyphicon glyphicon-ok-sign"></i> Create Role</button>
                                </div>
                            </div>
                        </div><!-- /.box-body -->


                    </form>

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</section>
<style>
    ul li {
        list-style:none;
    }
</style>
