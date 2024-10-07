<?php 
$book_id = $_GET['book_id'];
$result = [];
$get_books = "SELECT * FROM `books` WHERE `book_id` = '$book_id'";
$books = $GLOBALS['conn']->query($get_books);
while($row = $books->fetch_assoc()) {
	$result = $row;
}
?>
<div class="page-content">
	<p class="data-table-heading center-items flex space-bw  mr-t-10 mfs-8 bold">
		<span><?=$lang['book_details'];?></span>
	</p>
	<div class="row" style="padding: 0px 15px;">
		<div class="col-md-8" style="border: 1px solid #ddd; border-radius:5px">
			<div class="book-detail">
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['serial_number'];?></div>
					<div class="col-md-9">#<?=$_GET['book_id'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['book_title'];?></div>
					<div class="col-md-9"><?=$result['title'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['author'];?></div>
					<div class="col-md-9"><?=$result['author'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['publisher'];?></div>
					<div class="col-md-9"><?=$result['publisher'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['published_year'];?></div>
					<div class="col-md-9"><?=$result['published_year'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['category'];?></div>
					<div class="col-md-9"><?=get_categoryInfo($result['category_id'])['name'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['parts'];?></div>
					<div class="col-md-9"><?=$result['parts'];?></div>
				</div>
				<!-- <div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['part'];?></div>
					<div class="col-md-9"><?=$result['part_num'];?></div>
				</div> -->
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['number_of_copies'];?></div>
					<div class="col-md-9"><?=$result['number_of_copies'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['added_by'];?></div>
					<div class="col-md-9"><?=get_userInfo(null,$result['added_by'])['full_name'];?></div>
				</div>
				<div class="row" style="padding:5px 0px;">
					<div class="col-md-3 bold"><?=$lang['added_date'];?></div>
					<div class="col-md-9"><?=formatDateTime($result['added_date'], true);?></div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
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
    <div class="modal-dialog" role="BookStatus" style="max-width:400px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px;" onsubmit="return editBookCover(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookStatusLabel"><?=$lang['change_cover'];?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addBookStatusForm">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                            	<label for="coverImage" class="form-label label"><?=$lang['cover_image'];?> <span class="form-error"><?=$lang['required'];?></span></label>
								<input style="padding:2px;" class="form-control cursor" type="file" id="coverImage">
                                <input type="hidden" value="<?=$result['book_id'];?>" id="book_id4CoverChange">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mbtn primary cursor" style="width: 100px;"><?=$lang['submit'];?></button>
            </div>
        </form>
    </div>
</div>

