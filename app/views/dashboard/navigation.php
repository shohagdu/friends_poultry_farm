<?php
    $uriValue = $this->uri->segment(1);
    $uriValue2 = $this->uri->segment(2);
    if(empty($uriValue2)){
        $urlConcat = $uriValue;
    }else {
        $urlConcat = $uriValue . "/" . $uriValue2;
    }
    $acl_menu_info = $this->session->userdata('acl_info');
    $permission_info = $this->session->userdata('permission_info');
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?php
            $user = $this->session->userdata('user');
            $user_role = $this->session->userdata('user_role');
        ?>
        <ul class="sidebar-menu">
        <?php
        $childArray=[];
        $allChildArray=[];
        if(!empty($acl_menu_info)){
            foreach($acl_menu_info as $main_menu){
                if(!isset($permission_info[$main_menu->id])){
                    continue;
                }
                $childArray=!empty($main_menu->all_sub_menu)?array_column($main_menu->all_sub_menu,'link'):'';

                ?>
                <li  class="treeview  <?php  echo( !empty($childArray) && (in_array($urlConcat,$childArray))?'active':'');  ?>" >
                    <a href="<?php echo base_url().$main_menu->link; ?>">
                        <i class="glyphicon glyphicon-circle-arrow-right"></i> <?php echo $main_menu->title ?>
                        <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <?php
                    if(!empty($main_menu->all_sub_menu)){
                        ?>
                        <ul class="treeview-menu">
                            <?php
                            foreach($main_menu->all_sub_menu as $sub_menu){
                                if(!isset($permission_info[$main_menu->id][$sub_menu->id]) ){
                                    continue;
                                }
                                if(empty($sub_menu->all_child_menu)){
                                    ?>
                                    <li class="treeview ">
                                        <a href="<?php echo base_url().$sub_menu->link; ?>">
                                            <i class="glyphicon glyphicon-tasks"></i> <?php echo $sub_menu->title ?>
                                        </a>
                                    </li>
                                <?php }else{  ?>
                                    <li class="treeview ">
                                        <a href="#">
                                            <i class="fa fa-folder"></i> <?php echo $sub_menu->title ?>
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </a>
                                        <?php
                                        if(!empty($sub_menu->all_child_menu)){
                                        ?>
                                        <ul class="treeview-menu  ">
                                            <?php
                                            foreach($sub_menu->all_child_menu as $child_menu){
                                                if(!isset($permission_info[$main_menu->id][$sub_menu->id][$child_menu->id]) ){
                                                    continue;
                                                }
                                                ?>
                                                <li class="treeview active">
                                                    <a href="<?php echo base_url().$child_menu->link; ?>">
                                                        <i class="glyphicon glyphicon-tasks"></i> <?php echo $child_menu->title ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php
                                        }
                                    }
                                    ?>

                            <?php }  ?>

                        </ul>
                    <?php }  ?>
                </li>
            <?php  } } ?>
        </ul>



    </section>
</aside>