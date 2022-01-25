<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span    id="show_message"></span></div></div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo (!empty($title)?$title:'') ?></h3>

                </div>
                <form action="" method="POST" id="purchaseInfoForm" role="form">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Product Name / Code</label>
                                    <input type="text" id="productName_1" required data-type="productName"
                                           placeholder="Search Product Name / Code" class="productName form-control
                                           changeSearchProduct">
                                    <input type="hidden" name="productID" id="productID_1" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top: 25px">
                                <button type="button"  class="btn btn-primary btn-md
                                changeSearchProduct"><i class="glyphicon glyphicon-search"></i> Search</button>
                                <a href="<?php echo site_url('purchases/searchPurchaseProduct'); ?>" class="btn btn-warning
                    pull-right" title="Reset Search"><i class="glyphicon glyphicon-refresh"></i> Reset Search</a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-sm-12">
                    <div class="showReports"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</section>
