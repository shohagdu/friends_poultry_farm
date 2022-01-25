
<option value="">--(Select Expense Sub Head)--</option>
<?php foreach ($sub_head as $row) { ?>
    <option <?php
    if (!empty($id) && $id == $row['subheadid']) {
        echo "selected";
    }
    ?> value="<?php echo $row['subheadid']; ?>">
        <?php echo $row['title']; ?></option><?php
}?>