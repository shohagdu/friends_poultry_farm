<table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
    <thead>
    <tr>
        <td class="font-weight-bold"> SL</td>
        <td class="font-weight-bold"> Purchase ID</td>
        <td class="font-weight-bold"> Date</td>
        <td class="font-weight-bold width30per"> Product Info</td>
        <td class="font-weight-bold " > Total Purchase  </td>
        <td class="font-weight-bold"> Note  </td>

    </tr>
    </thead>
    <tbody>
    <?php
    $tPurchase=0;
    $i=1;
    if(!empty($info)){
        foreach ($info as $row) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <?php echo (!empty($row->purchase_id)?$row->purchase_id:''); ?>
                </td>

                <td nowrap="">
                    <?php echo (!empty($row->purchase_date)?date('d, M, Y',strtotime($row->purchase_date)):''); ?>
                </td>
                <td>
                    <?php echo (!empty($row->productCodesInfo)?$row->productCodesInfo:''); ?>
                </td>
                <td><i class="badge"><?php echo $totalPruchase=(!empty($row->totalPrice)?number_format($row->totalPrice,2,'.',''):'0.00'); $tPurchase+=$totalPruchase ?></i></td>
                <td>
                    <?php echo (!empty($row->note)?$row->note:''); ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>

    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" class="text-right">Total Summery</th>
        <th><i class="badge"><?php echo number_format($tPurchase,2); ?></i></th>
        <th></th>

    </tr>
    </tfoot>
</table>
