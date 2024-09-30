<!-- Modal -->
<div class="modal fade" data-bs-focus="false" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="Category" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return saveCategory(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel"><?php echo $lang['add_category_title']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addCategoryForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="categoryName"><?php echo $lang['category_name']; ?> <span class="form-error"><?php echo $lang['this_is_required']; ?></span></label>
                                <input type="text" placeholder="<?php echo $lang['category_name_placeholder']; ?>" class="form-control" id="categoryName">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="desc"><?php echo $lang['description']; ?> <span class="form-error"><?php echo $lang['this_is_required']; ?></span></label>
                                <textarea type="text" placeholder="<?php echo $lang['description_placeholder']; ?>" class="form-control" id="desc"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?php echo $lang['save']; ?></button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" data-bs-focus="false" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="Category" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return editCategory(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryLabel"><?php echo $lang['edit_category_title']; ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addCategoryForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="categoryName4Edit"><?php echo $lang['category_name']; ?> <span class="form-error"><?php echo $lang['this_is_required']; ?></span></label>
                                <input type="hidden" id="category_id4Edit">
                                <input type="text" placeholder="<?php echo $lang['category_name_placeholder']; ?>" class="form-control" id="categoryName4Edit">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="desc4Edit"><?php echo $lang['description']; ?> <span class="form-error"><?php echo $lang['this_is_required']; ?></span></label>
                                <textarea type="text" placeholder="<?php echo $lang['description_placeholder']; ?>" class="form-control" id="desc4Edit"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcCategoryStatus"><?php echo $lang['status']; ?> <span class="form-error"><?php echo $lang['this_is_required']; ?></span></label>
                                <select class="form-control" id="slcCategoryStatus">
                                    <option value="active"><?php echo $lang['active']; ?></option>
                                    <option value="deleted"><?php echo $lang['deleted']; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?php echo $lang['edit']; ?></button>
            </div>
        </form>
    </div>
</div>


<style>
    input.form-control {
        padding: 7px;
    }
</style>