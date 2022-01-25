<table  class=' table table-bordered table-hover' >
    <thead>
        <tr>
            <th>S/L</th>
            <th>Stock No</th>
            <th>Date</th>
            <th class="width30per">Product Codes</th>
            <th class="width20per text-right">Qty * Unit Price = Total Price</th>
            <th>Note</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i=1;
            if(!empty($record)){
                foreach ($record as $row){
                    if(!empty($row->id)){
                    ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo (!empty($row->purchase_id)?$row->purchase_id:'') ?></td>
                        <td><?php echo (!empty($row->purchase_date)?date('d M, Y',strtotime($row->purchase_date)):'')
                            ?></td>
                        <td><?php echo (!empty($row->name)?$row->name.' ['.$row->productCode.']':'') ?></td>
                        <td class="text-right"><?php echo (!empty($row->total_item)?$row->total_item.' * '.$row->unit_price
                                .'='
                                .$row->total_price:'')
                            ?></td>
                        <td><?php echo (!empty($row->note)?$row->note:'') ?></td>
                        <td>
                           <?php echo  '<a href="'. base_url('purchases/update/'.$row->id).'" target="_blank"  class="btn btn-primary  btn-xs"  ><i  class="glyphicon glyphicon-pencil"></i> Edit</a> <a href="'. base_url('purchases/view_purchage_info/'.$row->id).'" target="_blank" class="btn btn-info  btn-xs"   ><i  class="glyphicon glyphicon-share-alt"></i> View</a>'; ?>
                        </td>
                    </tr>
            <?php
                    }
                }
            }

        ?>

    </tbody>
</table>
