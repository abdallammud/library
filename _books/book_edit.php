<div class="modal fade" data-bs-focus="false" id="editBook" tabindex="-1" role="dialog" aria-labelledby="editBookLabel" aria-hidden="true">
    <div class="modal-dialog" role="Category" style="max-width:800px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; margin-top: -15px;" onsubmit="return editBook(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookLabel"><?= $lang['edit_book'] ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editBookForm">
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="bookTitle4Edit"><?= $lang['book_title'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="hidden" id="book_id" name="">
                                <input type="text" placeholder="<?= $lang['book_title_placeholder'] ?>" class="form-control" id="bookTitle4Edit">
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="isbn4Edit"><?= $lang['isbn'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="text" placeholder="<?= $lang['isbn_placeholder'] ?>" class="form-control" id="isbn4Edit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="authorName4Edit"><?= $lang['author_name'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="text" placeholder="<?= $lang['author_name_placeholder'] ?>" class="form-control" id="authorName4Edit">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="publisher4Edit"><?= $lang['publisher'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="text" placeholder="<?= $lang['publisher_placeholder'] ?>" class="form-control" id="publisher4Edit">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="published_year4Edit"><?= $lang['published_year'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <select class="form-control" id="published_year4Edit">
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
                    </div>
                    <div class="row">
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label" for="slcBookCategory4Edit"><?= $lang['category'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <select class="form-control" id="slcBookCategory4Edit" name="slcBookCategory4Edit">
                                    <option value=""><?= $lang['choose'] ?></option>
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
                                <label class="label required" for="number_of_copies4Edit"><?= $lang['number_of_copies'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="number" placeholder="1" class="form-control" id="number_of_copies4Edit">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="parts4Edit"><?= $lang['parts'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="number" placeholder="1" class="form-control" id="parts4Edit">
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="part_num4Edit"><?= $lang['part'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="number" placeholder="1" class="form-control" id="part_num4Edit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label" for="slcBookStatus4Edit"><?= $lang['status'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <select class="form-control" id="slcBookStatus4Edit">
                                    <option value="active"><?= $lang['available'] ?></option>
                                    <option value="not available"><?= $lang['not_available'] ?></option>
                                    <option value="deleted"><?= $lang['deleted'] ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-8"></div>
                        <div class="col col-lg-4">
                            <div class="row">
                                <div class="col col-sm-12">
                                    <button type="submit" class="mbtn cursor primary ld-ext-right running full">
                                        <span class="text"><?= $lang['submit'] ?></span>
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

<div class="modal fade" data-bs-focus="false" id="editBookStatus" tabindex="-1" role="dialog" aria-labelledby="editBookStatusLabel" aria-hidden="true">
    <div class="modal-dialog" role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return editBookStatus(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel"><?= $lang['edit_status'] ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addBookStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcBookStatus"><?= $lang['status'] ?><span class="form-error"><?= $lang['required'] ?></span></label>
                                <input type="hidden" id="book_id4StatusChange">
                                <select class="form-control" id="slcBookStatus">
                                    <option value="active"><?= $lang['available'] ?></option>
                                    <option value="not available"><?= $lang['not_available'] ?></option>
                                    <option value="deleted"><?= $lang['deleted'] ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?= $lang['submit'] ?></button>
            </div>
        </form>
    </div>
</div>
