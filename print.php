<?php 
// require("./assets/fpdf186/fpdf.php");
// require("./assets/fpdf186/barcode/FpdfBarcode.php");
require("./assets/fpdf186/phpqrcode/qrlib.php");
require('./assets/fpdf186/code128.php');

require('./incs/config.php');
require('./incs/utils.php');

reload(); 
if(isset($_GET['report'])) {
	if($_GET['report'] == 'books') {
		require('reports/allBooks.php');
	} else if($_GET['report'] == 'customers') {
		require('reports/allCustomers.php');
	} else if($_GET['report'] == 'book_transactions') {
		require('reports/book_transactions.php');
	} else if($_GET['report'] == 'customer_transactions') {
		require('reports/customer_transactions.php');
	} else if($_GET['report'] == 'booksCheckedout') {
		require('reports/books_checked_out.php');
	} else if($_GET['report'] == 'overdueBooks') {
		require('reports/overdue_books.php');
	} else if($_GET['report'] == 'returnedBooks') {
		require('reports/returned_books.php');
	}
} else {header("Location: /");}

?>