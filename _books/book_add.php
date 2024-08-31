<div class="modal fade" data-bs-focus="false" id="addBook" tabindex="-1" role="dialog" aria-labelledby="addBookLabel" aria-hidden="true">
    <div class="modal-dialog " role="Category" style="max-width:800px;">
        <form class="modal-content" style="border-radius: 14px 14px 0px 0px; margin-top: -15px; " onsubmit="return submitBook(this)">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookLabel">ADD BOOK</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="addBookForm">
                    <div class="row">
						<div class="col col-lg-6">
							<div class="form-group">
				                <label class="label required" for="bookTitle">Book title <span class="form-error">This is required</span></label>
				                <input  type="text" placeholder="Book title - required" class="form-control"  id="bookTitle" >
				            </div>
						</div>
						<div class="col col-lg-6">
							<div class="form-group">
				                <label class="label required" for="isbn">ISBN <span class="form-error">This is required</span></label>
				                <input  type="text" placeholder="ISBN - required" class="form-control"  id="isbn" >
				            </div>
						</div>
						<div class="col col-lg-6">
							<div class="form-group">
				                <label class="label required" for="authorName">Author name <span class="form-error">This is required</span></label>
				                <input  type="text" placeholder="Author name - required" class="form-control"  id="authorName" >
				            </div>
						</div>
						<div class="col col-lg-6">
							<div class="form-group">
				                <label class="label required" for="publisher">Publisher <span class="form-error">This is required</span></label>
				                <input  type="text" placeholder="Publisher " class="form-control"  id="publisher" >
				            </div>
						</div>
						<div class="col col-lg-6">
							<div class="form-group">
				                <label class="label required" for="published_year">Published year <span class="form-error">This is required</span></label>
				                <select class="form-control" id="published_year" >
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
						<div class="col col-lg-6">
							<div class="form-group">
				                <label class="label" for="slcBookCategory">Category <span class="form-error">This is required</span></label>
				                <select type="text" class="form-control" id="slcBookCategory" name="slcBookCategory">
				                    <option value="">Select</option>
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
						<div class="col col-lg-4">
							<div class="mb-3 form-group">
								<label for="coverImage" class="form-label label">Cover Image <span class="form-error">This is required</span></label>
								<input style="padding:2px;" class="form-control cursor" type="file" id="coverImage">
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
										<span class="text">Submit</span>
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

<script>
	/*addEventListener("DOMContentLoaded", (event) => {
	    // loadBooks();
	    Books();

	    tinymce.init({
			selector: 'textarea#Book',
			height : "380",
			setup: function(ed) {
		        ed.on('keyup', function(event) {
		            let Book = tinyMCE.get('Book').getContent();
		            tinyMCE.get('excerpt').setContent('');
		            if (Book.length > 200) Book = Book.slice(0,200) 
		            tinyMCE.get('excerpt').setContent(Book);	            
		        });
		    }
		});

		tinymce.init({
			selector: 'textarea#excerpt',
			height : "250",

		});
	});*/
</script>