<?php require('book_add.php'); ?>
<div class="page-content">
	<p class="data-table-heading center-items flex space-bw mr-b-20 mr-t-10 mfs-8 bold">
		<span>جميع الكتب  </span>
		<!-- <a href="./articles/create"  class="mbtn cursor primary">Add Book</a> -->
		<?php if($_SESSION['create'] == 'on') { ?>
			<button type="button" data-bs-toggle="modal" data-bs-target="#addBook" class="mbtn cursor primary">إضافة كتاب  </button>
		<?php } ?>
	</p>
	<div class="row justify-end">
		<div class="col-lg-3">
			<div class="form-group">
            	<label class="label" for="categoryFilter">فئة <span class="form-error">This is required</span></label>
            	<select type="text" class="form-control" id="categoryFilter" name="categoryFilter">
                	<option value="">الجميع</option>
                	<?php 
                        $get_categories = "SELECT * FROM `categories` WHERE `status` NOT IN ('deleted')";
                        $categories = $GLOBALS['conn']->query($get_categories);
                        while($categoriesRow = $categories->fetch_assoc()) {
                            $name = $categoriesRow['name'];
                            $category_id = $categoriesRow['id'];

                            echo '<option value="'.$category_id.'">'.$name.'</option>';
                        }

                	?>
            	</select>
        	</div>
		</div>
		<div class="col-lg-3">
			<div class="form-group">
            	<label class="label" for="statusFilter">حالة   <span class="form-error">This is required</span></label>
            	<select type="text" class="form-control" id="statusFilter" name="statusFilter">
                	<option value="">الجميع</option>
                	<option value="active">متوفر  </option>
                	<option value="not available">غير متوفر  </option>
            	</select>
        	</div>
		</div>
	</div>
	<table style="width: 100%;" class="table mfs-8  mcon mfs-9 table-striped " id="allBooksDT"></table>
</div>
<?php require('book_edit.php'); ?>
<script>
	addEventListener("DOMContentLoaded", (event) => {
		let categoryFilter = $('#categoryFilter').val();
		let statusFilter = $('#statusFilter').val();
	    loadBooks(categoryFilter, statusFilter);

	    $('#categoryFilter, #statusFilter').on('change', (e) => {
			categoryFilter = $('#categoryFilter').val();
			statusFilter = $('#statusFilter').val();
			loadBooks(categoryFilter, statusFilter);
	    })

	});
</script>