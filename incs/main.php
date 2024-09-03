<?php 
// session_start();

require('utils.php');
$role = $_SESSION['role'];
$myUser = $_SESSION['myUser'];

// Classes
require('Modal.php');
require('Books.php');
require('Users.php');
require('Categories.php');
require('Customers.php');
require('Borrowing.php');
require('BookReturns.php');

$result = array('error' => true, 'msg' => 'Incorrect addess', 'status' => 401);
if(isset($_GET['action'])) {
	if($_GET['action'] == 'save') {
		if(isset($_GET['save'])) {
			if($_GET['save'] == 'employee') {
				$result['msg'] = 'Employee saved succefully';
				$result['status'] = 201;

				$fullName 	= $_POST['fullName'];
				$phone 		= $_POST['phone'];
				$email 		= $_POST['email'];
				$username 	= $_POST['username'];
				$slcRole 	= $_POST['slcRole'];
				$password 	= $_POST['password'];
				$password   	= password_hash($password, PASSWORD_DEFAULT);

				$userActions = $userPrivileges = [];
				if(isset($_POST['userActions'])) $userActions 	= $_POST['userActions'];
				if(isset($_POST['userPrivileges'])) $userPrivileges	= $_POST['userPrivileges'];

				$actions 	= rtrim(implode(",", $userActions), ',');
				$privileges = rtrim(implode(",", $userPrivileges), ',');

				checkAccess('users', 'create', 'Can\'t create a user. No privileges');

				// Check if username already exist
		        $checkUser = "SELECT `username` FROM `users` WHERE `username` = '$username' AND `status` <> 'deleted'";
		        $userSet = $GLOBALS['conn']->query($checkUser);
		        if($userSet->num_rows > 0) {
		            $result['msg'] = ' Username name already exists. Please select differnt username.';
		            $result['error'] = true;
		            $result['errType'] = 'username';
		            echo json_encode($result); 
		            exit();
		        }

		         $stmt = $GLOBALS['conn']->prepare("INSERT INTO `users` (`full_name`, `phone`, `email`, `username`, `password`, `role`, `user_actions`, `user_privileges`, `reg_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		        $stmt->bind_param("sssssssss", $fullName, $phone, $email, $username, $password, $slcRole, $actions, $privileges, $myUser);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t record username.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' User saved succefully.';
		            $result['error'] = false;
		        }
			} else if($_GET['save'] == 'category') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$desc = NULL;

				if(isset($_POST['desc'])) $desc = $_POST['desc'];
				$categoryName = $_POST['categoryName'];

				checkAccess('categories', 'create', 'Can\'t create a category. No privileges');

				// Check if username already exist
		        $check_exist = "SELECT `name` FROM `categories` WHERE `name` = '$categoryName' AND `status` <> 'deleted'";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This category already exists.';
		            $result['error'] = true;
		            $result['errType'] = 'category';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("INSERT INTO `categories` (`name`, `description`, `added_by`) VALUES (?, ?, ?)");
		        $stmt->bind_param("sss", $categoryName, $desc, $myUser);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t record category.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Category saved succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['save'] == 'book') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;
				$result['error'] = false;

				$bookTitle 		= $_POST['bookTitle'];
				$isbn 			= $_POST['isbn'];
				$authorName 	= $_POST['authorName'];
				$publisher 		= $_POST['publisher'];
				$published_year = $_POST['published_year'];
				$slcBookCategory = $_POST['slcBookCategory'];

				checkAccess('books', 'create', 'Can\'t create a book. No privileges');

				$check_exist = $GLOBALS['conn']->query("SELECT * FROM `books` WHERE `isbn` = '$isbn' AND `status` <> 'deleted'");
				if($check_exist->num_rows > 0) {
					$result['error'] = true;
            		$result['msg'] = "ISBN Number already exists.";
            		echo json_encode($result);
					exit();
				}

				$image = '';

				$stmt = $GLOBALS['conn']->prepare("INSERT INTO `books` (`title`, `cover_image`, `isbn`, `author`, `publisher`, `published_year`, `status`, `category_id`, `added_by`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		        $stmt->bind_param("sssssssss", $bookTitle, $image, $isbn, $authorName, $publisher, $published_year, $status, $slcBookCategory, $myUser);
		        $status = 'active';
		        $uploadOk = false;
				// Check if form is submitted and there is no error
				if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
					// Get file information
				    $target_dir = "../assets/images/books/";
				    $file_name = basename($_FILES["file"]["name"]);

				    $temp = explode(".", $_FILES["file"]["name"]);
			    	$newfilename = round(microtime(true)) . '.' . end($temp);

				    $target_file = $target_dir . $newfilename;
				    $uploadOk = true;

				    // Check if image file is a actual image or fake image
			        $check = getimagesize($_FILES["file"]["tmp_name"]);
			        if ($check == false) {
			            $result['error'] = true;
			            $result['msg'] = 'File is not an image.';
			            $uploadOk = false;
			            echo json_encode($result);
						exit();
			        }

			        // Check if file already exists
				    /*if (file_exists($target_file)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, post image  already exists.";
			            echo json_encode($result);
						exit();
				    }*/

				    // Check file size (optional)
				    if ($_FILES["file"]["size"] > 5000000) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, your file is too large.";
			            echo json_encode($result);
						exit();
				    }

				    // Allow certain file formats
				    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "webp");
				    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
				    if (!in_array($file_extension, $allowed_extensions)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			            echo json_encode($result);
						exit();
				    }

				    if($uploadOk) {
				    	$image = $newfilename;
				    	if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			            	$result['error'] = true;
		            		$result['msg'] = "Sorry, there was an error uploading your file.";
		            		echo json_encode($result);
							exit();
			            }
				    } else {
				        $result['error'] = true;
	            		$result['msg'] = "Sorry, your file was not uploaded. Book not saved";
	            		echo json_encode($result);
	            		exit();
				    }
				} /*else {
				    $result['error'] = true;
            		$result['msg'] = "No file uploaded or upload error. Book not saved";
            		echo json_encode($result);
            		exit();
				}*/

				if($stmt->execute()) {
                	$result['error'] = false;
            		$result['msg'] = "Book saved succefully.";
		            $result['id'] = $stmt->insert_id;
                } else {
                	$result['error'] = true;
            		$result['msg'] = "Something went wrong with data storing.";
            		echo json_encode($result);
					exit();
                }
			} else if($_GET['save'] == 'customer') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$email = '';

				if(isset($_POST['email'])) $email = $_POST['email'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];

				checkAccess('customers', 'create', 'Can\'t create a customer. No privileges');

				// Check if username already exist
		        $check_exist = "SELECT `name` FROM `customers` WHERE `name` = '$name' AND `phone_number` = '$phone' AND `membership_status` <> 'deleted'";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This customer already exists.';
		            $result['error'] = true;
		            $result['errType'] = 'customer';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("INSERT INTO `customers` (`name`, `phone_number`, `email`, `added_by`) VALUES (?, ?, ?, ?)");
		        $stmt->bind_param("ssss", $name, $phone, $email, $myUser);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t record customer.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Customer saved succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['save'] == 'borrow') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$customer_id 	= $_POST['customer_id'];
				$isbn 			= $_POST['isbn'];
				$borrow_date 	= date('Y-m-d H:i:s');
				$dueDate 		= $_POST['dueDate'] . date(" H:i:s");

				checkAccess('transactions', 'create', 'Can\'t give a book to a customer. No privileges');

				// Check if username already exist
		        $check_exist = "SELECT * FROM `borrowing` WHERE `customer_id` = '$customer_id' AND `book_isbn` = '$isbn' AND `status` = 'on hold'";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This customer already has this book.';
		            $result['error'] = true;
		            $result['errType'] = 'borrowing';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("INSERT INTO `borrowing` (`customer_id`, `book_isbn`, `borrow_date`, `due_date`, `added_by`) VALUES (?, ?, ?, ?, ?)");
		        $stmt->bind_param("sssss", $customer_id, $isbn, $borrow_date, $dueDate, $myUser);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t record transaction.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Transaction saved succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			}
		} else {
			$result['msg'] = 'Incorrect action';
		}
		
		echo json_encode($result);
	} else if($_GET['action'] == 'load') {
		if(isset($_GET['load'])) {
			$role = '';
			$status = '';

			$length = 20;
			$searchParam = '';
			$orderBy = '';
			$order = 'ASC';
			$draw = 0;
			$start = 0;

			if(isset($_POST['role'])) $role = $_POST['role'];
			if(isset($_POST['status'])) $status = $_POST['status'];
			if(isset($_POST['length'])) $length = $_POST['length'];
			if(isset($_POST['start'])) $start = $_POST['start'];
			if(isset($_POST['draw'])) $draw = $_POST['draw'];
			if(isset($_POST['search'])) $searchParam = $_POST['search']['value'];

			if(isset($_POST['order'])) {
				$orderBy = $_POST['order'][0]['column'];
				$order = strtoupper($_POST['order'][0]['dir']);
			}

			$dataset = array();
			if($_GET['load'] == 'employees') {
				$result['status'] = 201;
				$result['error'] = false;
				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'full_name';
					if($orderBy == '1') $orderBy = 'phone';
					if($orderBy == '2') $orderBy = 'email';
					if($orderBy == '3') $orderBy = 'username';
					if($orderBy == '4') $orderBy = 'status';
					if($orderBy == '5') $orderBy = 'role';
				}
				$get_employees = "SELECT * FROM `users` WHERE `status` NOT IN ('Deleted') ";
				// ORDER BY `reg_date` DESC
				if($searchParam) {
					$get_employees .= " AND (`full_name` LIKE '%$searchParam%' OR `phone` LIKE '%$searchParam%' OR `username` LIKE '%$searchParam%' OR `email` LIKE '%$searchParam%')";
				}

				if($orderBy) {
					$get_employees .= " ORDER BY `$orderBy` $order";
				}
				$get_employees .= " LIMIT 0, ".$length;
				$employees = $GLOBALS['conn']->query($get_employees);
				if($employees->num_rows > 0) {
					$result['foundRows'] = $employees->num_rows;
					$result['error'] = false;

					while($row = $employees->fetch_assoc()) {
						$dataset[] = $row;
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $employees->num_rows;
					$result['iTotalDisplayRecords'] = $employees->num_rows;

					$result['msg'] = $employees->num_rows . " records were found.";
				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				}
			} else if($_GET['load'] == 'categories') {
				$result['status'] = 201;
				$result['error'] = false;
				// var_dump($_POST);
				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'name';
					if($orderBy == '1') $orderBy = 'description';
					if($orderBy == '2') $orderBy = 'status';
					if($orderBy == '3') $orderBy = 'added_date';
				}
				$get_categories = "SELECT * FROM `categories` WHERE `status` != 'deleted' ";
				// ORDER BY `added_date` DESC
				if($searchParam) {
					$get_categories .= " AND (`name` LIKE '%$searchParam%' OR `description` LIKE '%$searchParam%')";
				}

				if($orderBy) {
					$get_categories .= " ORDER BY `$orderBy` $order";
				}
				$noLimit = $get_categories;
				$get_categories .= " LIMIT $start, ".$length;
				$categories = $GLOBALS['conn']->query($get_categories);
				$allCategories = $GLOBALS['conn']->query($noLimit);
				if($categories->num_rows > 0) {
					$result['foundRows'] = $categories->num_rows;
					$result['error'] = false;

					while($row = $categories->fetch_assoc()) {
						// $dataset[] = $row;
						$id = $row['id'];
						$name = $row['name'];
						$description = $row['description'];
						
						$status 	= $row['status'];
						$added_date = new dateTime($row['added_date']);
						$added_date = $added_date->format('F d Y');

						$dataset[] = array('name' => $name, 'category_id' => $id, 'description' => $description, 'created_at' => $added_date, 'status' => ucwords($status));
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $allCategories->num_rows;
					$result['iTotalDisplayRecords'] = $allCategories->num_rows;
				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				
				}
			} else if($_GET['load'] == 'books') {
				$result['status'] = 201;
				$result['error'] = false;

				// var_dump($_POST); exit();
				$categoryFilter = '';
				$statusFilter = '';

				if(isset($_POST['categoryFilter'])) $categoryFilter = $_POST['categoryFilter'];
				if(isset($_POST['statusFilter'])) $statusFilter = $_POST['statusFilter'];

				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'title';
					if($orderBy == '1') $orderBy = 'isbn';
					if($orderBy == '2') $orderBy = 'author';
					if($orderBy == '3') $orderBy = 'published_year';
					if($orderBy == '4') $orderBy = 'category_id';
					if($orderBy == '5') $orderBy = 'status';
					if($orderBy == '6') $orderBy = 'added_date';
				}
				$get_books = "SELECT `book_id`, `title`, `author`, `publisher`, `published_year`, B.`status`, `isbn`, `category_id`, B.`added_date`, `name` FROM `books` B INNER JOIN `categories` C ON C.`id` = B.`category_id` WHERE B.`status` NOT IN ('deleted') ";
				// ORDER BY `reg_date` DESC
				if($searchParam) {
					$get_books .= " AND (`author` LIKE '%$searchParam%' OR `title` LIKE '%$searchParam%' OR `isbn` LIKE '%$searchParam%' OR `name` LIKE '%$searchParam%' OR `publisher` LIKE '%$searchParam%' OR `published_year` LIKE '%$searchParam%' OR B.`status` LIKE '%$searchParam%')";
				} else{
					if($categoryFilter) {
						$get_books .= " AND B.`category_id` = '$categoryFilter'";
					} 

					if($statusFilter) {
						$get_books .= " AND B.`status` LIKE '$statusFilter'";
					}
				}

				
				if($orderBy) {
					if($orderBy == 'category_id') {
						$get_books .= " ORDER BY `name` $order";
					} else {
						$get_books .= " ORDER BY B.`$orderBy` $order";
					}
				} else {
					$get_books .= " ORDER BY B.`book_id` DESC";
				}

				$noLimit = $get_books;
				$get_books .= " LIMIT $start, ".$length;
				$allBooks = $GLOBALS['conn']->query($noLimit);
				$books = $GLOBALS['conn']->query($get_books);
				if($books->num_rows > 0) {
					$result['error'] = false;

					while($row = $books->fetch_assoc()) {
						$book_id 	= $row['book_id'];
						$title 		= $row['title'];
						$isbn 		= $row['isbn'];
						$author 	= $row['author'];
						$category_id 	= $row['category_id'];
						$publisher 		= $row['publisher'];
						$published_year = $row['published_year'];
						$status 		= $row['status'];
						$added_date 	= new dateTime($row['added_date']);

						$statusTxt = ucwords($status);
						if(strtolower($status) == 'active') $statusTxt = 'Available';

						$added_date = $added_date->format('F d, Y');
						$category = $row['name'];

						$dataset[] = array('book_id' => $book_id, 'title' => $title, 'isbn' => $isbn, 'category' => $category, 'category_id' => $category_id, 'author' => $author, 'status' => $status, 'statusTxt' => $statusTxt, 'publisher' => $publisher, 'published_year' => $published_year, 'created_at' => $added_date);
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $allBooks->num_rows;
					$result['iTotalDisplayRecords'] = $allBooks->num_rows;

				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				}
			} else if($_GET['load'] == 'customers') {
				$result['status'] = 201;
				$result['error'] = false;
				// var_dump($_POST);
				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'name';
					if($orderBy == '1') $orderBy = 'phone_number';
					if($orderBy == '2') $orderBy = 'email';
					if($orderBy == '3') $orderBy = 'membership_status';
					if($orderBy == '4') $orderBy = 'added_date';
				}
				$get_customers = "SELECT * FROM `customers` WHERE `membership_status` != 'deleted' ";
				// ORDER BY `added_date` DESC
				if($searchParam) {
					$get_customers .= " AND (`name` LIKE '%$searchParam%' OR `phone_number` LIKE '%$searchParam%' OR `email` LIKE '%$searchParam%')";
				}

				if($orderBy) {
					$get_customers .= " ORDER BY `$orderBy` $order";
				}
				$noLimit = $get_customers;
				$get_customers .= " LIMIT $start, ".$length;
				$customers = $GLOBALS['conn']->query($get_customers);
				$allcustomers = $GLOBALS['conn']->query($noLimit);
				if($customers->num_rows > 0) {
					$result['foundRows'] = $customers->num_rows;
					$result['error'] = false;

					while($row = $customers->fetch_assoc()) {
						// $dataset[] = $row;
						$id = $row['id'];
						$name = $row['name'];
						$email = $row['email'];
						$phone_number = $row['phone_number'];
						
						$membership_status 	= $row['membership_status'];
						$added_date = new dateTime($row['added_date']);
						$added_date = $added_date->format('F d Y');

						$dataset[] = array('name' => $name, 'id' => $id, 'email' => $email, 'phone_number' => $phone_number, 'created_at' => $added_date, 'membership_status' => ucwords($membership_status));
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $allcustomers->num_rows;
					$result['iTotalDisplayRecords'] = $allcustomers->num_rows;
				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				
				}
			} else if($_GET['load'] == 'transactions') {
				$result['status'] = 201;
				$result['error'] = false;

				if(isset($_POST['order'])) {
					if($orderBy == '0') $orderBy = 'name';
					if($orderBy == '1') $orderBy = 'book_isbn';
					if($orderBy == '2') $orderBy = 'borrow_date';
					if($orderBy == '3') $orderBy = 'status';
					if($orderBy == '4') $orderBy = 'due_date';
				}
				$get_transactions = "SELECT `name`, `phone_number`, `title`, `author`, `isbn`, BR.`id`, `borrow_date`, BR.`status`, `due_date`, BR.`added_date` FROM `borrowing` BR INNER JOIN `books` B ON B.`isbn` = BR.`book_isbn` INNER JOIN `customers` C ON BR.`customer_id` = C.`id` WHERE B.`status` NOT IN ('deleted') ";
				// ORDER BY `reg_date` DESC
				if($searchParam) {
					$get_transactions .= " AND (`name` LIKE '%$searchParam%' OR `phone_number` LIKE '%$searchParam%' OR `title` LIKE '%$searchParam%' OR `author` LIKE '%$searchParam%' OR `isbn` LIKE '%$searchParam%')";
				} 
				
				if($orderBy) {
					if($orderBy == 'name') {
						$get_transactions .= " ORDER BY `name` $order";
					} else {
						$get_transactions .= " ORDER BY BR.`$orderBy` $order";
					}
				} else {
					$get_transactions .= " ORDER BY BR.`id` DESC";
				}

				$noLimit = $get_transactions;
				$get_transactions .= " LIMIT $start, ".$length;
				$allTransactions = $GLOBALS['conn']->query($noLimit);
				$transactions = $GLOBALS['conn']->query($get_transactions);
				if($transactions->num_rows > 0) {
					$result['error'] = false;

					while($row = $transactions->fetch_assoc()) {
						$id 		= $row['id'];
						$title 		= $row['title'];
						$isbn 		= $row['isbn'];
						$author 	= $row['author'];
						$customer 		= $row['name'];
						$phone_number 	= $row['phone_number'];
						$borrow_date 	= new dateTime($row['borrow_date']);
						$due_date 		= new dateTime($row['due_date']);
						$status 		= $row['status'];
						$added_date 	= new dateTime($row['added_date']);

						$statusTxt = ucwords($status);

						$added_date = $added_date->format('F d, Y');
						$borrow_date = $borrow_date->format('F d, Y');
						$due_date = $due_date->format('F d, Y');
						
						$dataset[] = array('id' => $id, 'title' => $title, 'isbn' => $isbn, 'customer' => $customer, 'phone_number' => $phone_number, 'author' => $author, 'status' => $status, 'statusTxt' => $statusTxt, 'borrow_date' => $borrow_date, 'due_date' => $due_date, 'created_at' => $added_date);
					}
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = $allTransactions->num_rows;
					$result['iTotalDisplayRecords'] = $allTransactions->num_rows;

				} else {
					// $result['error'] = true;
					$result['msg'] = "No records found";
					$result['data']  	= $dataset;
					$result['draw'] 	= $draw;
					$result['iTotalRecords'] = 0;
					$result['iTotalDisplayRecords'] = 0;
				}
			}
		} else {
			$result['msg'] = 'Incorrect action';
		}

		echo json_encode($result);
	} else if($_GET['action'] == 'update') {
		if(isset($_GET['update'])) {
			$updated_date = date('Y-m-d h:i:s');
			if($_GET['update'] == 'employee') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$user_id 	= $_POST['user_id'];
				$fullName 	= $_POST['fullName'];
				$phone 		= $_POST['phone'];
				$email 		= $_POST['email'];
				$slcRole 	= $_POST['slcRole'];
				$slcStatus 	= $_POST['slcStatus'];


				$userActions = $userPrivileges = [];
				if(isset($_POST['userActions'])) $userActions 	= $_POST['userActions'];
				if(isset($_POST['userPrivileges'])) $userPrivileges	= $_POST['userPrivileges'];

				$actions 	= rtrim(implode(",", $userActions), ',');
				$privileges = rtrim(implode(",", $userPrivileges), ',');

				checkAccess('users', 'update', 'Can\'t update a user. No privileges');

				if(strtolower($slcStatus) == 'deleted') {
					checkAccess('users', 'delete', 'Can\'t delete a user. No privileges');
				}

				$updated_date = date('Y-m-d h:i:s');
		        $stmt = $GLOBALS['conn']->prepare("UPDATE `users` SET `full_name` =?, `phone` = ?, `email` = ?,  `role` = ?, `user_actions` =?, `user_privileges` =?,  `status` = ?, `updated_date` = ?, `updated_by` = ? WHERE `user_id` = ?");
		        $stmt->bind_param("ssssssssss", $fullName, $phone, $email,  $slcRole, $actions, $privileges, $slcStatus, $updated_date,  $myUser, $user_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t edit employee details.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Employee editted succefully.';
		            $result['error'] = false;
		        }
			} else if($_GET['update'] == 'category') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$desc = NULL;

				if(isset($_POST['desc'])) $desc = $_POST['desc'];
				$categoryName = $_POST['categoryName'];
				$category_id = $_POST['category_id'];
				$slcCategoryStatus = $_POST['slcCategoryStatus'];

				checkAccess('categories', 'update', 'Can\'t update a category. No privileges');

				if(strtolower($slcCategoryStatus) == 'deleted') {
					checkAccess('categories', 'delete', 'Can\'t delete a category. No privileges');
				}

				// Check if username already exist
		        $check_exist = "SELECT `name` FROM `categories` WHERE `name` = '$categoryName' AND `status` <> 'deleted' AND `id` NOT IN ($category_id)";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This category already exists.';
		            $result['error'] = true;
		            $result['errType'] = 'category';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("UPDATE `categories` SET `name` =?, `status` =?, `description` =?, `updated_date` =?, `updated_by` =? WHERE `id` = ?");
		        $stmt->bind_param("ssssss", $categoryName, $slcCategoryStatus, $desc, $updated_date,  $myUser, $category_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t update category.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Category editted succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['update'] == 'book') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;
				$result['error'] = false;

				$book_id 		= $_POST['book_id'];
				$bookTitle 		= $_POST['bookTitle'];
				$isbn 			= $_POST['isbn'];
				$authorName 	= $_POST['authorName'];
				$publisher 		= $_POST['publisher'];
				$published_year = $_POST['published_year'];
				$slcBookCategory = $_POST['slcBookCategory'];
				$slcBookStatus 	= $_POST['slcBookStatus'];

				checkAccess('books', 'update', 'Can\'t update a book. No privileges');

				if(strtolower($slcBookStatus) == 'deleted') {
					checkAccess('books', 'delete', 'Can\'t delete a book. No privileges');
				}

				$check_exist = $GLOBALS['conn']->query("SELECT * FROM `books` WHERE `isbn` = '$isbn' AND `status` <> 'deleted' AND `book_id` <> '$book_id'");
				if($check_exist->num_rows > 0) {
					$result['error'] = true;
            		$result['msg'] = "ISBN Number already exists.";
            		echo json_encode($result);
					exit();
				}

				$stmt = $GLOBALS['conn']->prepare("UPDATE `books` SET `title` =?, `isbn` =?, `author` =?, `publisher` =?, `published_year` =?, `status` =?, `category_id` =?, `updated_by` =?, `updated_date` =? WHERE `book_id` =?");
		        $stmt->bind_param("ssssssssss", $bookTitle, $isbn, $authorName, $publisher, $published_year, $slcBookStatus, $slcBookCategory, $myUser, $updated_date, $book_id);
				
				if($stmt->execute()) {
                	$result['error'] = false;
            		$result['msg'] = "Book editted succefully.";
		            $result['id'] = $stmt->insert_id;
                } else {
                	$result['error'] = true;
            		$result['msg'] = "Something went wrong with data storing.";
            		echo json_encode($result);
					exit();
                }	
			} else if($_GET['update'] == 'bookStatus') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$status = $_POST['status'];
				$book_id = $_POST['book_id'];

				checkAccess('books', 'update', 'Can\'t change a book status. No privileges');

				if(strtolower($status) == 'deleted') {
					checkAccess('books', 'delete', 'Can\'t delete a book. No privileges');
				}

		        $stmt = $GLOBALS['conn']->prepare("UPDATE `books` SET `status` =?, `updated_date` =?, `updated_by` =? WHERE `book_id` = ?");
		        $stmt->bind_param("ssss", $status, $updated_date,  $myUser, $book_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t update category.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Book status changed succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['update'] == 'bookCover') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				checkAccess('books', 'update', 'Can\'t change a book cover. No privileges');
				
				

				$image = '';
				$uploadOk = false;
				$book_id = $_POST['book_id'];

				if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
					// Get file information
				    $target_dir = "../assets/images/books/";
				    $file_name = basename($_FILES["file"]["name"]);

				    $temp = explode(".", $_FILES["file"]["name"]);
			    	$newfilename = round(microtime(true)) . '.' . end($temp);

				    $target_file = $target_dir . $newfilename;
				    $uploadOk = true;

				    // Check if image file is a actual image or fake image
			        $check = getimagesize($_FILES["file"]["tmp_name"]);
			        if ($check == false) {
			            $result['error'] = true;
			            $result['msg'] = 'File is not an image.';
			            $uploadOk = false;
			            echo json_encode($result);
						exit();
			        }

				    // Check file size (optional)
				    if ($_FILES["file"]["size"] > 5000000) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, your file is too large.";
			            echo json_encode($result);
						exit();
				    }

				    // Allow certain file formats
				    $allowed_extensions = array("jpg", "jpeg", "png", "gif", "webp");
				    $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
				    if (!in_array($file_extension, $allowed_extensions)) {
				        $uploadOk = false;
				        $result['error'] = true;
			            $result['msg'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			            echo json_encode($result);
						exit();
				    }

				    if($uploadOk) {
				    	$image = $newfilename;
				    	if (!move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			            	$result['error'] = true;
		            		$result['msg'] = "Sorry, there was an error uploading your file.";
		            		echo json_encode($result);
							exit();
			            }
				    } else {
				        $result['error'] = true;
	            		$result['msg'] = "Sorry, your file was not uploaded. Book cover not changed";
	            		echo json_encode($result);
	            		exit();
				    }
				} else {
					checkAccess('books', 'delete', 'Can\'t delete a book. No privileges');
				}

		        $stmt = $GLOBALS['conn']->prepare("UPDATE `books` SET `cover_image` =?, `updated_date` =?, `updated_by` =? WHERE `book_id` = ?");
		        $stmt->bind_param("ssss", $image, $updated_date,  $myUser, $book_id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t update book cover.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Book cover changed succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else if($_GET['update'] == 'customer') {
				$result['msg'] = 'Correct action';
				$result['status'] = 201;

				$name 	= $_POST['name'];
				$phone 	= $_POST['phone'];
				$email 	= $_POST['email'];
				$id 	= $_POST['id'];
				$status = $_POST['status'];

				checkAccess('customers', 'update', 'Can\'t update a customer. No privileges');

				if(strtolower($status) == 'deleted') {
					checkAccess('customers', 'delete', 'Can\'t delete a customer. No privileges');
				}

				// Check if username already exist
		        $check_exist = "SELECT `name` FROM `customers` WHERE `name` = '$name' AND `membership_status` <> 'deleted' AND `id` NOT IN ($id)";
		        $existSet = $GLOBALS['conn']->query($check_exist);
		        if($existSet->num_rows > 0) {
		            $result['msg'] = ' This customer already exists.';
		            $result['error'] = true;
		            $result['errType'] = 'customer';
		            echo json_encode($result); 
		            exit();
		        }

		        $stmt = $GLOBALS['conn']->prepare("UPDATE `customers` SET `name` =?, `phone_number` =?, `email` =?, `membership_status` =?, `updated_date` =?, `updated_by` =? WHERE `id` = ?");
		        $stmt->bind_param("sssssss", $name, $phone, $email, $status, $updated_date, $myUser, $id);
		        if(!$stmt->execute()) {
		            $result['msg']    = ' Couln\'t update customer.';
		            $result['error'] = true;
		            $result['errType']  = 'sql';
		            $result['sqlErr']   = $stmt->error;
		            echo json_encode($result); exit();
		        } else {
		        	$result['msg'] = ' Customer editted succefully.';
		            $result['error'] = false;
		            $result['id'] = $stmt->insert_id;
		        }
			} else {
				$result['msg'] = 'Incorrect action';
			}
		} else {
			$result['msg'] = 'Incorrect action';
		}
		echo json_encode($result);
	} else if($_GET['action'] == 'get') {
		if($_GET['get'] == 'category') {
			$category_id = $_POST['category_id'];
			$result = [];
			$get_category = "SELECT * FROM `categories` WHERE `id` = '$category_id'";
		    $categorySet = $GLOBALS['conn']->query($get_category);
		    while($row = $categorySet->fetch_assoc()) {
		    	$result[] = $row;
		    }
		    echo json_encode($result);
		} else if($_GET['get'] == 'book') {
			$book_id = $_POST['book_id'];
			$result = [];
			$get_books = "SELECT * FROM `books` WHERE `book_id` = '$book_id'";
		    $books = $GLOBALS['conn']->query($get_books);
		    while($row = $books->fetch_assoc()) {
		    	$result[] = $row;
		    }
		    echo json_encode($result);
		} else if($_GET['get'] == 'customer') {
			$id = $_POST['id'];
			$result = [];
			$get_customer = "SELECT * FROM `customers` WHERE `id` = '$id'";
		    $customerSet = $GLOBALS['conn']->query($get_customer);
		    while($row = $customerSet->fetch_assoc()) {
		    	$result[] = $row;
		    }
		    echo json_encode($result);
		}
	} else if($_GET['action'] == 'search') {
		if($_GET['search'] == 'customer') {
			$search = $_POST['search'];
			$result = '';
			$get_customer = "SELECT * FROM `customers` WHERE `membership_status` <> 'deleted' AND (`name` LIKE '%$search%' OR `phone_number` LIKE '%$search%' OR `email` LIKE '%$search%') LIMIT 10";
		    $customerSet = $GLOBALS['conn']->query($get_customer);
		    if($customerSet->num_rows > 0) {
			    while($row = $customerSet->fetch_assoc()) {
			    	$id 			= $row['id'];
			    	$phone_number 	= $row['phone_number'];
			    	$name 			= $row['name'];
			    	$email 			= $row['email'];

			    	$result .= '<div onclick="return catchCustomer(\'' . $id . '\', \'' . $name . '\', \'' . $phone_number . '\');" class="result-item">
	            		<p class="">
	            			<span class="title bold">Name:</span>
	            			<span class="val">'.$name.'</span>
	            		</p>
	            		<p class="">
	            			<span class="title bold">Phone:</span>
	            			<span class="val">'.$phone_number.'</span>
	            		</p>
	            	</div>';
			    }
			} else {
				$result = '<p class="empty-result">No customers found</p>';
			}
		    echo $result;
		} else if($_GET['search'] == 'book') {
			$search = $_POST['search'];
			$result = '';
			$get_book = "SELECT * FROM `books` WHERE `status` <> 'deleted' AND (`title` LIKE '%$search%' OR `author` LIKE '%$search%' OR `isbn` LIKE '%$search%') LIMIT 10";
		    $bookSet = $GLOBALS['conn']->query($get_book);
		    if($bookSet->num_rows > 0) {
			    while($row = $bookSet->fetch_assoc()) {
			    	$id 		= $row['book_id'];
			    	$title 		= $row['title'];
			    	$isbn 		= $row['isbn'];
			    	$author 	= $row['author'];

			    	$result .= '<div onclick="return catchBook(\'' . $id . '\', \'' . $isbn . '\', \'' . $title . '\', \'' . $author . '\');" class="result-item">
	            		<p class="">
	            			<span class="title bold">ISBN:</span>
	            			<span class="val">'.$isbn.'</span>
	            		</p>
	            		<p class="">
	            			<span class="title bold">Title:</span>
	            			<span class="val">'.$title.'</span>
	            		</p>
	            		<p class="">
	            			<span class="title bold">Author:</span>
	            			<span class="val">'.$author.'</span>
	            		</p>
	            	</div>';
			    }
			} else {
				$result = '<p class="empty-result">No customers found</p>';
			}
		    echo $result;
		}
	}
}




?>