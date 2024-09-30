<div class="page-content">

    <p class="data-table-heading center-items flex space-bw mr-b-20 mr-t-10 mfs-8 bold">
        <span><?php echo $lang['all_transactions']; ?></span>
        <button type="button" data-bs-toggle="modal" data-bs-target="#addTransaction" class="mbtn cursor primary"><?php echo $lang['add_new']; ?></button>
    </p>
    <table style="width: 100%;" class="table mfs-8 mcon mfs-9 table-striped" id="transactionsTable"></table>
</div>
<?php require('transaction_dp.php'); ?>
<script>
    addEventListener("DOMContentLoaded", (event) => {
        loadTransactions();
        transactions();
    });
</script>
