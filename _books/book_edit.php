<div class="modal fade"  data-bs-focus="false" id="editBook" tabindex="-1" role="dialog" aria-labelledby="editBookLabel" aria-hidden="true">
    <div class="modal-dialog " role="Category" style="max-width:800px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; margin-top: -15px; " onsubmit="return editBook(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="editBookLabel">تحرير الكتاب</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editBookForm">
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="bookTitle4Edit">عنوان الكتاب<span class="form-error">This is required</span></label>
                                <input type="hidden" id="book_id" name="">
                                <input  type="text" placeholder="عنوان الكتاب - مطلوب" class="form-control"  id="bookTitle4Edit" >
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="isbn4Edit">رقم ISBN  <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="رقم ISBN - مطلوب  " class="form-control"  id="isbn4Edit" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label required" for="authorName4Edit">اسم المؤلف   <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="اسم المؤلف - مطلوب  " class="form-control"  id="authorName4Edit" >
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="publisher4Edit">الناشر <span class="form-error">This is required</span></label>
                                <input  type="text" placeholder="الناشر " class="form-control"  id="publisher4Edit" >
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="published_year4Edit">سنة النشر <span class="form-error">This is required</span></label>
                                <select class="form-control" id="published_year4Edit" >
                                    <?php
                                        // Set your desired start and end years
                                        $startYear = 2024;
                                        $endYear = 1900;

                                        // Generate the year options
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
                                <label class="label" for="slcBookCategory4Edit">فئة   <span class="form-error">This is required</span></label>
                                <select type="text" class="form-control" id="slcBookCategory4Edit" name="slcBookCategory4Edit">
                                    <option value="">يختار</option>
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
                                <label class="label required" for="number_of_copies4Edit">عدد النسخ   <span class="form-error">This is required</span></label>
                                <input  type="number" placeholder="1" class="form-control"  id="number_of_copies4Edit" >
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="parts4Edit"> أجزاء  <span class="form-error">This is required</span></label>
                                <input  type="number" placeholder="1" class="form-control"  id="parts4Edit" >
                            </div>
                        </div>
                        <div class="col col-lg-3">
                            <div class="form-group">
                                <label class="label required" for="part_num4Edit"> جزء  <span class="form-error">This is required</span></label>
                                <input  type="number" placeholder="1" class="form-control"  id="part_num4Edit" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="form-group">
                                <label class="label" for="slcBookStatus4Edit">حالة <span class="form-error">This is required</span></label>
                                <select class="form-control"  id="slcBookStatus4Edit" >
                                    <option value="active">متوفر  </option>
                                    <option value="not available">غير متوفر</option>
                                    <option value="deleted">يمسح  </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-lg-8">
                        </div>
                        <div class="col col-lg-4">
                            <div class="row">
                                
                                <div class="col col-sm-12">
                                    <button type="submit" class="mbtn cursor primary ld-ext-right running full ">
                                        <span class="text">يُقدِّم  </span>
                                        <span class="ld loader " ></span>
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
    <div class="modal-dialog " role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return editBookStatus(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel">تحرير حالة الكتاب   </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addBookStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="label" for="slcBookStatus">حالة   <span class="form-error">This is required</span></label>
                                <input type="hidden" id="book_id4StatusChange">
                                <select class="form-control"  id="slcBookStatus" >
                                    <option value="active">متاح  </option>
                                    <option value="not available">غير متاح   </option>
                                    <option value="deleted">يمسح  </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="mbtn primary cursor" style="width: 100px;">يتقدم  </button>
            </div>
        </form>
    </div>
</div>
<script>
    addEventListener("DOMContentLoaded", (event) => {
       
    });
</script>