<table  class="table-style table" style="width:100%;border:1px solid #d0d0d0;">
    <thead>
    <tr>
        <td class="font-weight-bold"> SL</td>
        <td class="font-weight-bold"> Product Info</td>
        <td class="font-weight-bold"> Purchase ID</td>
        <td class="font-weight-bold"> Date</td>

        <td class="font-weight-bold"> Qty</td>
        <td class="font-weight-bold"> Unit / Actual Purchase Price</td>
        <td class="font-weight-bold"> Total Purchase  </td>
        <td class="font-weight-bold"> Unit Sale Price</td>
        <td class="font-weight-bold"> Total Sale</td>
        <td class="font-weight-bold"> Appox. Profit</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $tPurchase=0;
    $tSale=0;
    $profiteLose=0;
    $i=1;
    if(!empty($info)){
        foreach ($info as $row) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td class="text-left">
                    <?php echo (!empty($row->name)? $row->name:'').(!empty($row->productCode)?' ['.$row->productCode.']':''); ?>
                </td>
                <td>
                    <?php echo (!empty($row->purchase_id)?$row->purchase_id:''); ?>
                </td>
                <td nowrap="">
                    <?php echo (!empty($row->purchase_date)?date('d, M, Y',strtotime($row->purchase_date)):''); ?>
                </td>


                <td><i class="badge"><?php echo (!empty($row->total_item)?$row->total_item:''); ?></i></td>
                <td>
                    <i class="badge bg-red-active"><?php echo (!empty($row->unit_price)?$row->unit_price:''); ?></i> /
                    <i class="badge bg-green-active"><?php echo (!empty($row->purchase_price)?$row->purchase_price:''); ?></i>

                </td>


                <td><i class="badge bg-green-active"><?php echo $totalPurchase=(!empty($row->total_item * $row->purchase_price)?number_format($row->total_item * $row->purchase_price,2,'.',''):''); $tPurchase+=$totalPurchase; ?></i></td>

                <td><i class="badge bg-aqua-active"><?php echo (!empty($row->unit_sale_price)?$row->unit_sale_price:''); ?></i></td>
                <td><i class="badge bg-aqua-active"><?php echo $totalSalse= (!empty($row->unit_sale_price * $row->total_item )?number_format($row->unit_sale_price *$row->total_item,2,'.',''):'0.00'); $tSale+=$totalSalse; ?></i</td>

                <td><i class="badge bg-maroon-gradient">
                        <?php echo $totalProfit=(!empty($totalSalse-$totalPurchase)?number_format($totalSalse-$totalPurchase,2,'.',''):'0.00');
                        $profiteLose+=$totalProfit ?></i>
                </td>

            </tr>
            <?php
        }
    }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6" class="text-right">Total Summery</th>
        <th><i class="badge bg-green-active"><?php echo number_format($tPurchase,2); ?></i></th>
        <th></th>
        <th><i class="badge bg-aqua-active"><?php echo number_format($tSale,2); ?></i></th>
        <th><i class="badge bg-maroon-gradient"><?php echo number_format($profiteLose,2); ?></i></th>


    </tr>
    </tfoot>
</table>
