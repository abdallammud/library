<!-- Modal -->
<div class="modal fade" data-bs-focus="false" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog " role="Category" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return saveCategory(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">إضافة فئة جديدة</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addCategoryForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="categoryName">اسم الفئة    <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="Category name" class="form-control"  id="categoryName" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="desc">وصف     <span class="form-error">This is required</span></label>
                                <textarea  type="text" placeholder="Description" class="form-control"  id="desc" ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">يحفظ  </button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" data-bs-focus="false" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog " role="Category" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return editCategory(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryLabel">تحرير الفئة  </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addCategoryForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="missingSerial">اسم الفئة   <span class="form-error">This is required</span></label>
                                <input type="hidden" id="category_id4Edit">
                                <input  type="text" placeholder="Category name" class="form-control"  id="categoryName4Edit" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="desc4Edit">وصف   <span class="form-error">This is required</span></label>
                                <textarea  type="text" placeholder="Description" class="form-control"  id="desc4Edit" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="missingSerial">حالة   <span class="form-error">This is required</span></label>
                                <select class="form-control"  id="slcCategoryStatus" >
                                    <option value="active">نشيط  </option>
                                    <option value="deleted">يمسح  </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">يحرر  </button>
            </div>
        </form>
    </div>
</div>

<style>
    input.form-control {
        padding: 7px;
    }
</style>