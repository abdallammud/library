<?php 
require('utils.php');
$role = $_SESSION['role'];
$myUser = $_SESSION['myUser'];

$result = [];
$result['error'] = false;
if(isset($_GET['action'])) {
	if($_GET['action'] == 'get') {
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

		if($_GET['get'] == 'overdue-trans') {
			$result['status'] = 201;
			$result['error'] = false;

			if (isset($_POST['order'])) {
			    if ($orderBy == '0') $orderBy = 'name';
			    if ($orderBy == '1') $orderBy = 'book_isbn';
			    if ($orderBy == '2') $orderBy = 'borrow_date';
			    if ($orderBy == '3') $orderBy = 'due_date';
			}

			$get_transactions = "
			    SELECT DISTINCT C.`name`, C.`phone_number`, B.`title`, B.`author`, B.`isbn`, BR.`id`, BR.`borrow_date`, BR.`status`, BR.`due_date`, BR.`return_date`, BR.`added_date` FROM `borrowing` BR INNER JOIN `books` B ON B.`isbn` = BR.`book_isbn` INNER JOIN `customers` C ON BR.`customer_id` = C.`id` WHERE B.`status` NOT IN ('deleted')  AND BR.`due_date` < CURDATE()";

			// Adding search filter if $searchParam is set
			if ($searchParam) {
			    $get_transactions .= " AND ( C.`name` LIKE '%$searchParam%'  OR C.`phone_number` LIKE '%$searchParam%'  OR B.`title` LIKE '%$searchParam%'  OR B.`author` LIKE '%$searchParam%'  OR B.`isbn` LIKE '%$searchParam%')";
			}

			// Adding ORDER BY clause
			if ($orderBy) {
			    if ($orderBy == 'name') {
			        $get_transactions .= " ORDER BY C.`name` $order";
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
					$return_date 	= new dateTime($row['return_date']);
					$return_date1 	= $row['return_date'];

					$statusTxt = ucwords($status);

					$added_date = $added_date->format('F d, Y');
					$borrow_date = $borrow_date->format('F d, Y');
					$due_date = $due_date->format('F d, Y');
					$return_date = $return_date->format('F d, Y');

					if($return_date1 == '0000-00-00 00:00:00') {
						$return_date = '';
					}
					
					$dataset[] = array('id' => $id, 'title' => $title, 'isbn' => $isbn, 'customer' => $customer, 'phone_number' => $phone_number, 'author' => $author, 'status' => $status, 'statusTxt' => $statusTxt, 'borrow_date' => $borrow_date, 'due_date' => $due_date, 'return_date' => $return_date, 'created_at' => $added_date);
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
		} else if($_GET['get'] == 'cards') {
			// Count borrowed books = borrowing table
			// Count over due books = borrwing table where status = on hold
			// Count all books = books table  where status not equal to delete
			// Count all customers = cusstomers table where status not equal to delete

			// Get Week days ending with current day eg Thursday, friday, saturday --- today = Wednesday
			// Get books borrowed each day of these days from table borrowing using column added date
			// Also get returned books for each day from same table using column return_date

			// Count borrowed books
			$query = "SELECT COUNT(*) AS count_borrowed FROM borrowing";
			$resp = $conn->query($query);
			$row = $resp->fetch_assoc();
			$result['count_borrowed'] = prefixNumberWithZeros($row['count_borrowed']);

			// Count overdue books
			$query = "SELECT COUNT(*) AS count_overdue FROM borrowing WHERE status = 'on hold' AND `due_date` < CURDATE()";
			$resp = $conn->query($query);
			$row = $resp->fetch_assoc();
			$result['count_overdue'] = prefixNumberWithZeros($row['count_overdue']);

			// Count all books
			$query = "SELECT COUNT(*) AS count_all_books FROM books WHERE status != 'deleted'";
			$resp = $conn->query($query);
			$row = $resp->fetch_assoc();
			$result['count_all_books'] = prefixNumberWithZeros($row['count_all_books']);

			// Count all customers
			$query = "SELECT COUNT(*) AS count_all_customers FROM customers WHERE membership_status != 'deleted'";
			$resp = $conn->query($query);
			$row = $resp->fetch_assoc();
			$result['count_all_customers'] = prefixNumberWithZeros($row['count_all_customers']);

			// Get current day and weekdays
			$current_day = date('l'); // e.g., Wednesday
			$days_of_week = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
			$start_index = array_search($current_day, $days_of_week);
			$weekdays = array_merge(
			    array_slice($days_of_week, $start_index),
			    array_slice($days_of_week, 0, $start_index)
			);

			$first_item = array_shift($weekdays);
			array_push($weekdays, $current_day);

			// Get books borrowed and returned each day
			$books_borrowed_per_day = [];
			$books_returned_per_day = [];

			$books_borrowed_per_day['Saturday'] = 0;
			$books_borrowed_per_day['Sunday'] 	= 0;
			$books_borrowed_per_day['Monday'] 	= 0;
			$books_borrowed_per_day['Tuesday'] 	= 0;
			$books_borrowed_per_day['Wednesday'] 	= 0;
			$books_borrowed_per_day['Thursday'] 	= 0;
			$books_borrowed_per_day['Friday'] 		= 0;

			$books_returned_per_day['Saturday'] 	= 0;
			$books_returned_per_day['Sunday'] 		= 0;
			$books_returned_per_day['Monday'] 		= 0;
			$books_returned_per_day['Tuesday'] 		= 0;
			$books_returned_per_day['Wednesday'] 	= 0;
			$books_returned_per_day['Thursday'] 	= 0;
			$books_returned_per_day['Friday'] 		= 0;

		    $start_date = date('Y-m-d 00:00:00', strtotime("last $weekdays[0]"));
		    $end_date = date('Y-m-d 23:59:59', strtotime("today"));

		    // Get books borrowed on this day
		    $query = "SELECT * FROM borrowing WHERE added_date BETWEEN '$start_date' AND '$end_date' AND `status` != 'deleted'";
		    $resp = $conn->query($query);
		    // $row = $resp->fetch_assoc();
		    while ($row = $resp->fetch_assoc()) {
		    	$added_date = new DateTime($row['added_date']);
		    	$dayName = $added_date->format('l');
		    	$books_borrowed_per_day[$dayName] +=1;
		    }

		    $query = "SELECT * FROM borrowing WHERE return_date BETWEEN '$start_date' AND '$end_date' AND `status` = 'returned'";
		    $resp = $conn->query($query);
		    // $row = $resp->fetch_assoc();
		    while ($row 		= $resp->fetch_assoc()) {
		    	$return_date 	= new DateTime($row['return_date']);
		    	$dayName 		= $return_date->format('l');
		    	$books_returned_per_day[$dayName] +=1;
		    }

			$result['books_borrowed_per_day'] = $books_borrowed_per_day;
			$result['books_returned_per_day'] = $books_returned_per_day;
			$result['weekdays'] = $weekdays;


		}

		echo json_encode($result);



	}
}






?>