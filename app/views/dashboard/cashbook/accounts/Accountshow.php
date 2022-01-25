<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">View Account</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Account Name</th>
                            <td><?php echo $viewAccounts['accountName'] ?></td>
                        </tr>
                        <tr>
                            <th>Account Type</th>
                            <td><?php echo $viewAccounts['accountType'] ?></td>
                        </tr>
                        <?php if (!empty($viewAccounts['accountNumber'])) { ?>
                            <tr>
                                <th>Account Number</th>
                                <td><?php echo $viewAccounts['accountNumber'] ?></td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($viewAccounts['accountBranchName'])) { ?>
                            <tr>
                                <th>Branch Name</th>
                                <td><?php echo $viewAccounts['accountBranchName'] ?></td>
                            </tr>
                        <?php } ?>
                        <?php if (!empty($viewAccounts['note'])) { ?>
                            <tr>
                                <th>Note</th>
                                <td><?php echo $viewAccounts['note'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>
