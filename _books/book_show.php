<?php 
$book_id = $_GET['book_id'];
$result = [];
$get_books = "SELECT * FROM `books` WHERE `book_id` = '$book_id'";
$books = $GLOBALS['conn']->query($get_books);
while($row = $books->fetch_assoc()) {
	$result = $row;
}
?>
<div class="page-content" >
	<p class="data-table-heading center-items flex space-bw  mr-t-10 mfs-8 bold">
		<span>تفاصيل الكتاب</span>
	</p>
	<div class="row" style="padding: 0px 15px;">
		<!-- Left Column: Book Details -->
		<div class="col-md-8" style="border: 1px solid #ddd; border-radius:5px">
			<div class="book-detail">
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">رقم سري  </div>
					<div class="col-md-9">#<?=$_GET['book_id'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">عنوان  </div>
					<div class="col-md-9"><?=$result['title'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">مؤلف  </div>
					<div class="col-md-9"><?=$result['author'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">الناشر  </div>
					<div class="col-md-9"><?=$result['publisher'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">تاريخ النشر  </div>
					<div class="col-md-9"><?=$result['published_year'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">فئة  </div>
					<div class="col-md-9"><?=get_categoryInfo($result['category_id'])['name'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"> أجزاء   </div>
					<div class="col-md-9">
						<?=$result['parts'];?> 
					</div>
				</div>

				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">جزء  </div>
					<div class="col-md-9">
						<?=$result['part_num'];?> 
					</div>
				</div>
				
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">عدد النسخ  </div>
					<div class="col-md-9"><?=$result['number_of_copies'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold">تمت الإضافة بواسطة  </div>
					<div class="col-md-9"><?=get_userInfo(null,$result['added_by'])['full_name'];?></div>
				</div>
				<div class="row" style="padding:5px 0px;">
					<div class="col-md-3 bold">تاريخ الإضافة</div>
					<div class="col-md-9"><?=formatDateTime($result['added_date'], true);?></div>
				</div>
			</div>
		</div>

		<!-- Middle cover image -->
		<div class="col-md-4" >
			<?php if($result['cover_image']) { ?>
				<img style="width: 100%; height: 100%; max-height: 270px; border-radius: 5px 5px 0px 0px;" src="<?=BASE_URI;?>/assets/images/books/<?=$result['cover_image'];?>">
			<?php } else { ?>
				<img style="width: 100%; height: 100%; max-height: 270px; border-radius: 5px 5px 0px 0px;" src="<?=BASE_URI;?>/assets/images/no-cover.png">
			<?php } ?>
			<div style="background: var(--theme); color: var(--sidebar-active-color); padding: 10px; display: flex; justify-content: center; border-radius: 0px 0px 5px 5px; align-items:center;">
				<i class="bi mr-r-10 cursor bi-trash" onclick="return deleteCoverFromBook(<?=$result['book_id'];?>)"></i>
				<i class="bi cursor mr-l-10 bi-pencil" type="button" data-bs-toggle="modal" data-bs-target="#editBookCover"></i>
			</div>
		</div>
	</div>
</div>





















<div class="modal fade" data-bs-focus="false" id="editBookCover" tabindex="-1" role="dialog" aria-labelledby="editBookCoverLabel" aria-hidden="true">
    <div class="modal-dialog " role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; " onsubmit="return editBookCover(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel">تغيير غلاف الكتاب  </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addBookStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            	<label for="coverImage" class="form-label label">صورة الغلاف   <span class="form-error">This is required</span></label>
								<input style="padding:2px;" class="form-control cursor" type="file" id="coverImage">
                                <input type="hidden" value="<?=$result['book_id'];?>" id="book_id4CoverChange">
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
