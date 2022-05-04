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
                                    <h3 style=" text-align: center;font-weight: bold;"><?php echo (!empty
                                        ($todaySalesInfo->totalSale)
                                            ?$todaySalesInfo->totalSale:'0.00') ?></h3>
                                </div>
                                <hr>
                                <p style="font-size: 18px; text-align: center;font-weight: bold">TODAY SALES </p>
                            </div>
                        </div>
                    </div>

                </a>
                <?php
                $bg=[
                        3   =>  'bg-yellow',
                        7   =>  'bg-green',
                        8   =>  'bg-yellow',
                        11  =>  'bg-green',
                        12  =>  'bg-yellow',
                ];
                if(!empty($transSummery)){
                    foreach ($transSummery as $sumKey=> $summery){
                ?>
                        <div class="col-md-4">
                            <div class="small-box <?php echo (!empty($bg[$sumKey])?$bg[$sumKey]:''); ?>">
                                <div class="inner">
                                    <div style="height:35px;">
                                        <h3 style=" text-align: center;font-weight: bold;"><?php echo (!empty($summery)
                                                ?$summery:'0.00') ?></h3>
                                    </div>
                                    <hr>
                                    <p style="font-size: 18px; text-align: center;font-weight: bold"><?php echo (!empty
                                        ($transactionType[$sumKey])
                                            ?$transactionType[$sumKey]:''); ?> </p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </section>
</div>

