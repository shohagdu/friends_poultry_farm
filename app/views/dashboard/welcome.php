<div class="row">
    <section class="row content invoice">
        <div class="row">
            <div class="col-md-12">
                <?php
                     $isSuperAdmin = $this->session->userdata('abhinvoiser_1_1_role');
                ?>
                <a href="<?php   echo ((!empty($isSuperAdmin) && $isSuperAdmin=='superadmin')? base_url('reports/dailySalesStatement'):'')?>">
                    <div class="col-md-4">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <div style="height:35px;">
                                    <h4 style=" text-align: center"><?php echo (!empty($todaySalesInfo)?$todaySalesInfo:'0.00') ?></h4>
                                </div>
                                <hr>
                                <p style="font-size: 14px; text-align: center">TODAY SALES </p>
                            </div>

                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>
</div>

