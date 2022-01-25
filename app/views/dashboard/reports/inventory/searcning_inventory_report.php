<table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
    <thead>

    <tr>
        <td class="font-weight-bold"> SL</td>
        <td class="font-weight-bold"> Product name</td>
        <td class="font-weight-bold"> Brand</td>
        <td class="font-weight-bold"> Source</td>
        <td class="font-weight-bold"> p. type</td>
        <td class="font-weight-bold"> Stock In(Opening+In) </td>
        <td class="font-weight-bold"> Stock Out (Sale+Transfer)</td>
        <td class="font-weight-bold" >Balance</td>
        <td class="no-print font-weight-bold " style="width: 10%;">Action</td>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($info)){
        $i=1;
        foreach ($info as $row) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td class="text-left"><?php echo $row->name.' ['.$row->productCode.']'; ?></td>
                <td class="text-left"><?php echo $row->bandTitle; ?></td>
                <td class="text-left"><?php echo $row->sourceTitle; ?></td>
                <td><?php echo $row->ProductTypeTitle; ?></td>
                <td><i class="badge"><?php echo $row->debit_item_info; ?></i></td>
                <td><i class="badge"><?php echo $row->credit_item_info; ?></i></td>
                <td><i class="badge"><?php echo $row->current_stock_item; ?></i></td>
                <td class="no-print">
                    <a href="<?php echo base_url('reports/details_inventory_report/'.$row->id)
                    ?>" class="btn btn-info btn-xs"><i
                                class="glyphicon glyphicon-share-alt"></i>
                        Details</a>
                </td>

            </tr>
            <?php
        }
    }
    ?>

    </tbody>
</table>
