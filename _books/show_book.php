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
		<span>BOOK DETAILS</span>
	</p>
	<div class="row" style="padding: 0px 15px;">
		<!-- Left Column: Book Details -->
		<div class="col-md-8" style="border: 1px solid #ddd; border-radius:5px">
			<div class="book-detail">
				<div class="row" style="border-bottom: 1px solid #ddd; padding:15px">
					<div class="col-md-4 bold">Title:</div>
					<div class="col-md-8"><?=$result['title'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:15px">
					<div class="col-md-4 bold">Author:</div>
					<div class="col-md-8"><?=$result['author'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:15px">
					<div class="col-md-4 bold">Publisher:</div>
					<div class="col-md-8"><?=$result['publisher'];?></div>
				</div>
				<div class="row" style="border-bottom: 1px solid #ddd; padding:15px">
					<div class="col-md-4 bold">Published Date:</div>
					<div class="col-md-8"><?=$result['published_year'];?></div>
				</div>
				<div class="row" style="padding:15px">
					<div class="col-md-4 bold">Category:</div>
					<div class="col-md-8"><?=get_categoryInfo($result['category_id'])['name'];?></div>
				</div>
			</div>
		</div>

		<!-- Right Column: Metadata -->
		<div class="col-md-4">
			<div class="metadata">
				<div class="row">
					<div class="col-md-4 bold">Added by:</div>
					<div class="col-md-8"><?=get_userInfo(null,$result['added_by'])['full_name'];?></div>
				</div>
				<div class="row">
					<div class="col-md-4 bold">Date:</div>
					<div class="col-md-8"><?=formatDateTime($result['added_date'], true);?></div>
				</div>
			</div>
		</div>
	</div>
</div>
