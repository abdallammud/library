<div class="modal fade" data-bs-focus="false" id="addBook" tabindex="-1" role="dialog" aria-labelledby="addBookLabel" aria-hidden="true">
    <div class="modal-dialog" role="Category" style="max-width:800px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; margin-top: -15px;" onsubmit="return submitBook(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookLabel"><?= $lang['add_book']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addBookForm">
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="bookTitle"><?= $lang['book_title']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="text" placeholder="<?= $lang['book_title']; ?> - <?= $lang['this_is_required']; ?>" class="form-control" id="bookTitle">
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="isbn"><?= $lang['isbn']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="text" placeholder="<?= $lang['isbn']; ?> - <?= $lang['this_is_required']; ?>" class="form-control" id="isbn">
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="authorName"><?= $lang['author_name']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="text" placeholder="<?= $lang['author_name']; ?> - <?= $lang['this_is_required']; ?>" class="form-control" id="authorName">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="publisher"><?= $lang['publisher']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="text" placeholder="<?= $lang['publisher']; ?>" class="form-control" id="publisher">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="published_year"><?= $lang['published_year']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <select class="form-control" id="published_year">
                                    <?php
                                        $startYear = 2024;
                                        $endYear = 1900;
                                        for ($year = $startYear; $year >= $endYear; $year--) {
                                            echo '<option value="' . $year . '">' . $year . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="slcBookCategory"><?= $lang['category']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <select type="text" class="form-control" id="slcBookCategory" name="slcBookCategory">
                                    <option value=""><?= $lang['choose']; ?></option>
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
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="number_of_copies"><?= $lang['number_of_copies']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="number" placeholder="1" class="form-control" id="number_of_copies">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="parts"><?= $lang['parts']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="number" placeholder="1" class="form-control" id="parts">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="part_num"><?= $lang['part']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input type="number" placeholder="1" class="form-control" id="part_num">
                            </div>
                        </div>
                        <div class="col col-lg-4">
                            <div class="mb-3 form-group">
                                <label for="coverImage" class="form-label label"><?= $lang['cover_image']; ?> <span class="form-error"><?= $lang['this_is_required']; ?></span></label>
                                <input style="padding:2px;" class="form-control cursor" type="file" id="coverImage">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-8"></div>
                        <div class="col col-lg-4">
                            <div class="row">
                                <div class="col col-sm-12">
                                    <button type="submit" class="mbtn cursor primary ld-ext-right running full ">
                                        <span class="text"><?= $lang['submit']; ?></span>
                                        <span class="ld loader"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" data-bs-focus="false" id="uploadCSVModal" tabindex="-1" role="dialog" aria-labelledby="uploadCSVModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="Upload" style="max-width:400px;">
        <form id="uploadCSVForm" onsubmit="return submitCSV(this);">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookLabel"><?= $lang['upload_book']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="csvFile" class="form-label"><?=$lang['select_csv_file'];?></label>
                <input type="file" class="form-control" id="csvFile" accept=".csv" required>
              </div>
              <a href="./assets/books-upload-sample.csv" class="btn btn-link" download><?=$lang['download_sample']; ?></a>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=$lang['close'] ;?></button>
              <button type="submit" class="btn btn-primary">
                <span class="text"><?=$lang['upload']; ?></span>
                <span class="loader d-none"></span>
              </button>
            </div>
          </div>
        </form>
    </div>
</div>

<script>
    // Your JavaScript functions here
</script>

<style type="text/css">
    select.form-control:not([size]):not([multiple]) {
        height: calc(2.25rem + 2px);
        height: 2rem;
    }
</style>
