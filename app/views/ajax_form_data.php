  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->

<table id="example1" class="table table-bordered">
    <thead>
        <tr>
            <th>SL</th>
            <th>Account</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach ($results as $eachResult) {
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <?php
                    $house_name = $this->PRODUCTS->get_single_data_by_single_column('tbl_pos_warehouses', 'warehouseID', $eachResult['warehouseID']);
                    echo $house_name['warehouseName'];
                    ?>
                </td>
                <td><?php echo $eachResult['ttlbalance'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>