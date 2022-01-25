<style>
    @media print {
        #hideDiv {
            display: none;
        }

        .no-border {
            border: none !important;
        }
    }

    #table-style td {
        border: 1px solid lightgray;
        padding-top: 2px;
        padding-bottom: 2px;
    }

    #table-style th {
        border: 1px solid lightgray;
        padding-top: 2px;
        padding-bottom: 2px;
    }

</style>

<div class="col-md-12">
    <div class="box no-border">


        <div class="col-sm-12" style="text-align:center;margin-top:10px;">
            <div style="font-size:22px;font-weight:bold">Dhaka University Club</div>
            <div style="font-size:18px;font-weight:bold">Member List</div>
        </div>
        <div class="col-sm-7" style="margin-bottom:5px;">
            <div class="clearfix"></div>
            <?php echo "<b>Date:</b>" . date('d-m-Y'); ?>
        </div>
        <div class="col-sm-5" style="float:right;margin-bottom:10px;" id="hideDiv">
            <button class="btn btn-info btn-sm pull-right" onclick="window.print()" style="margin-right:5px;"><i
                        class="glyphicon glyphicon-print"></i> Print
            </button>

        </div>

        <table id="table-style" class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="width:5%;">SL.</th>
                <th>Code</th>
                <th>Member Name</th>
                <th>Mobile</th>
                <th>Designation</th>
                <th>Subs. Amount</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;
            //echo "<pre>";
          //  print_r($get_all_member_department_wise);
            //exit;
            if (!empty($get_all_member_department_wise)) {
                foreach ($get_all_member_department_wise as $department) { ?>
                    <?php if (!empty($department->title)) { ?>
                        <tr>
                            <td colspan="7"
                                style="font-weight:bold;font-size:14px;background: lightgray"><?php echo $department->title; ?></td>
                        </tr>
                        <?php

                        $i = 1;
                       if(!empty($department->member_info)){
                        foreach ($department->member_info as $member) {
                            ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $member->member_code ?></td>
                                <td><?php echo $member->name ?></td>
                                <td><?php echo $member->mobile ?></td>
                                <td><?php echo $member->designationTitle ?></td>
                                <td><?php echo ($member->sub_ctg_title != NULL)? $member->sub_ctg_title." [".$member->sub_amount."] ":""; ?></td>
                                <td style="color: <?php echo ($member->member_status=='Active')?'green':'red'; ?>"><?php echo $member->member_status ?></td>

                            </tr>
                        <?php } } ?>
                    <?php }
                }
            }

            ?>

            </tbody>

        </table>
    </div>
</div>
</div>
