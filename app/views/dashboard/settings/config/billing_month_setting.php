<link rel="stylesheet" media="screen,projection" type="text/css"
      href="<?php echo base_url(); ?>assets/datepicker/jquery-ui.css"/>
<script src="<?php echo base_url(); ?>assets/datepicker/jquery-ui.js"></script>
<section class="content">
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Billing Month Setting</h3>
                    <?php if ($this->session->flashdata('msg')) {
                        echo $this->session->flashdata('msg');
                    } ?>
                    <?php if ($this->session->flashdata('usingTransaction')) {
                        echo $this->session->flashdata('usingTransaction');
                    } ?>
                    <button class="btn btn-primary btn-xs pull-right" data-toggle="modal" onclick="addData()"
                            data-target="#myModal"><i
                            class="glyphicon glyphicon-plus"></i> Add New
                    </button>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width:2%;">SL.</th>
                            <th>Title</th>
                            <th style="width:11%;">Start Date</th>
                            <th style="width:10%;">End Date</th>
                            <th style="width:17%;">Subscription Month</th>
                            <th style="width:6%;">Sorting</th>
                            <th style="width:11%;">Is Current</th>
                            <th style="width:10%;">Status</th>
                            <th style="width:8%;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $sl = 1;
                        foreach ($get_bill_generate_month as $gen_month) { ?>
                            <tr>
                                <td><?php echo $sl; ?></td>
                                <td><?php echo $gen_month->title; ?></td>
                                <td><?php echo $gen_month->from_date; ?></td>
                                <td><?php echo $gen_month->to_date; ?></td>
                                <td><?php echo $gen_month->gen_month; ?></td>
                                <td><?php echo $gen_month->sorting; ?></td>
                                <td><?php echo ($gen_month->is_current==1)?"Current":"Not Current"; ?></td>
                                <td><?php echo ($gen_month->status==1)?"<span style='color:green'>Active</span>":"<span style='color:red'>Inactive</span>"; ?></td>
                                <td>


<!--
                                    <button class="btn btn-info btn-xs"
                                            onclick="viewInfo('<?php echo $gen_month->id; ?>','<?php echo $gen_month->title; ?>','<?php echo $gen_month->sorting; ?>','<?php echo $gen_month->status; ?>')"
                                            data-toggle="modal" data-target="#myModal"><i
                                            class="glyphicon glyphicon-pencil"></i> Update
                                    </button>
                                    -->

                            </tr>
                            <?php $sl++; ?>
                        <?php } ?>
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
<script>
    function viewInfo(id, title,sorting,status) {
        $("#add_title").val(title);
        $("#sorting").val(sorting);
        $("#status").val(status);
        $("#upId").val(id);
        $("#saveBtn").hide();
        $("#updateBtn").show();
    }

    function addData() {
        $("#add_title").val('');
        $("#sorting").val('');
        $("#status").val(1);
        $("#upId").val('');
        $("#updateBtn").hide();
        $("#saveBtn").show();
    }

</script>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <form action="" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Billing Month</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4 text-right">
                            Title
                        </div>
                        <div class="col-sm-8">
                            <input placeholder="Enter Ttile" required type="text" class="form-control" name="add_title" id="add_title">
                        </div>

                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4 text-right">
                            Date Range
                        </div>
                        <div class="col-sm-8">
                            <input placeholder="Enter date range" required type="text" class="form-control" name="date_range" id="reservation">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4 text-right">
                            Subscription Month
                        </div>
                        <div class="col-sm-8">
                           <input type="text" required id="month_year"  name="month_year" value="<?php echo date('m/Y'); ?>" class="monthPicker form-control">
                        </div>
                    </div>


                    <div class="form-group col-sm-12">
                        <div class="col-sm-4 text-right">
                            Current
                        </div>
                        <div class="col-sm-8">
                            <input type="checkbox"  name="is_current" id="is_current">
                        </div>
                    </div>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4 text-right">
                            Sorting
                        </div>
                        <div class="col-sm-8">
                            <input type="text" required placeholder="Enter Sorting" class="form-control" name="sorting" id="sorting">
                        </div>
                    </div>

                    <div class="form-group col-sm-12">
                        <div class="col-sm-4 text-right">
                            Status
                        </div>
                        <div class="col-sm-8">
                            <select  class="form-control" name="status" id="status">
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>




                </div>
                <div class="clearfix"></div>

                <div class="modal-footer">
                    <div class="col-sm-12">
                        <div class="col-sm-4 text-right">

                        </div>
                        <div class="col-sm-8">
                            <input type="hidden" name="upId" id="upId">
                            <input type="submit" name="saveBtn" id="saveBtn" class="btn btn-success btn-sm"
                                   value="Save">
                            <input type="submit" name="updateBtn" id="updateBtn" class="btn btn-success btn-sm"
                                   value="Update">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>


<!-- /.content -->