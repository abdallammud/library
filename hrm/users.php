<div class="page-content has-table">
	<p class="data-table-heading center-items flex space-bw mr-b-20 mr-t-10 mfs-8 bold">
		<span><?php echo $lang['users_page_heading']; ?></span>
		<button type="button" data-bs-toggle="modal" data-bs-target="#addEmployee" class="mbtn cursor primary"><?php echo $lang['users_add_user_button']; ?></button>
	</p>
	<table style="width: 100%;" class="table mfs-8 mcon mfs-9 table-striped" id="allUsers"></table>
</div>
<?php require('add_employee.php'); ?>
<script>
	addEventListener("DOMContentLoaded", (event) => {
	    loadEmployees();
	});
</script>
