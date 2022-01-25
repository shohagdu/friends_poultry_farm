<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box-body" id="alert" style="display: none;"> <div class="callout callout-info"><span
                            id="show_message"></span></div></div>
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?php echo !empty($title)?$title:'' ?></h3>
                    <?php if($this->session->flashdata('msg')){ echo $this->session->flashdata('msg');  }?>
                    <?php if($this->session->flashdata('usingTransaction')){ echo $this->session->flashdata('usingTransaction');  }?>
                    <button  class="btn btn-info pull-right btn-sm" data-toggle="modal" onclick="addSettingInfo()"
                        data-target="#myModal"><i class="glyphicon glyphicon-plus"></i> Add</button>
                    <input type="hidden"  id="type_info" value="<?php echo !empty($type)?$type:'' ?>">
                </div>
                <div class="box-body">
                    <table id='settingsInfo' class='display dataTable table table-bordered table-hover' >
                        <thead>
                        <tr>
                            <th style="width: 10%;">SL.</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>

                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>

    </div>
</section>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <form action="" method="post" id="setting_info_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?php echo !empty($title)?$title:'' ?> Information</h4>
                </div>
                <div class="modal-body">
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Title
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required name="title" placeholder="Title"
                                   id="title">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-2 text-right">
                            Status
                        </div>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>

                            </select>
                        </div>
                    </div>




                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="col-sm-12 text-left">
                            <div class="box-body" id="alert_error" style="display: none;"> <div class="callout
                        callout-danger"><span id="show_error_save"></span></div></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-sm-12">
                            <input type="hidden" name="upId" id="upId" >
                            <input type="hidden" name="type" id="type" value="<?php echo !empty($type)?$type:'' ?>">
                            <input type="hidden" name="redierct_page" id="redierct_page" value="<?php echo !empty($redierct_page)?$redierct_page:'' ?>">

                            <button type="button" onclick="saveSettingInfo()" name="saveBtn" id="saveBtn" class="btn
                            btn-success submit_btn"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            <button type="button" name="updateBtn"  onclick="saveSettingInfo()" id="updateBtn"
                                    class="btn btn-success submit_btn
"><i  class="glyphicon glyphicon-ok-sign"></i> Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="glyphicon
                            glyphicon-remove"></i> Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>