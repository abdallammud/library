<?php require('book_add.php'); ?>
<div class="page-content">
    <p class="data-table-heading center-items flex space-bw mr-b-20 mr-t-10 mfs-8 bold">
        <span><?= $lang['all_books']; ?></span>
        <?php if($_SESSION['create'] == 'on') { ?>
            <span>
                <button type="button" data-bs-toggle="modal" data-bs-target="#addBook" class="mbtn cursor primary"><?= $lang['add_book']; ?></button>

                <button type="button" data-bs-toggle="modal" data-bs-target="#uploadCSVModal" class="mbtn cursor primary"><?= $lang['upload_book']; ?></button>
            </span>
        <?php } ?>
    </p>
    <div class="row justify-end">
        <div class="col-lg-3">
            <div class="form-group">
                <label class="label" for="categoryFilter"><?= $lang['category']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                <select type="text" class="form-control" id="categoryFilter" name="categoryFilter">
                    <option value=""><?= $lang['select_one']; ?></option>
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
                <label class="label" for="statusFilter"><?= $lang['status']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                <select type="text" class="form-control" id="statusFilter" name="statusFilter">
                    <option value=""><?= $lang['select_one']; ?></option>
                    <option value="active"><?= $lang['available']; ?></option>
                    <option value="not available"><?= $lang['not_available']; ?></option>
                </select>
            </div>
        </div>
    </div>
    <table style="width: 100%;" class="table mfs-8 mcon mfs-9 table-striped" id="allBooksDT"></table>
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
        });
    });
</script>
