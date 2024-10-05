<?php

// Extend the TCPDF class to create a custom footer
class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        // Set position to 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Author Name');
$pdf->SetTitle('Overdue Books Report');
$pdf->SetSubject('Overdue Books');

// Disable default header and footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(10, 10, 10); // left, top, right
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(20);

$pdf->SetAutoPageBreak(TRUE, 15);

// Add a page
$pdf->AddPage();

$pdf->SetFont('aefurat', '', 12);
$pdf->Image('./assets/images/logo.png', 125, 5, 50); // Adjust size as needed

// Set header rectangle
$pdf->SetFillColor(163, 185, 67);
$pdf->SetDrawColor(163, 185, 67);
$pdf->Rect(15, 40, 265, 0.2); // Adjusted position and width for landscape

$pdf->SetFont('aefurat', 'B', 13);
$pdf->SetXY(15, 45);
$pdf->Cell(0, 10, $lang['pdf_overdue_books_report'], 0, 1, 'C');

$pdf->SetFont('aefurat', '', 10);
$pdf->SetXY(15, 50);
$pdf->Cell(0, 10, $lang['pdf_print_date'] . date('F d, Y h:i:s A'), 0, 1, 'C');

$y = 60;

// Table Header
$pdf->SetFont('aefurat', 'B', 10);
$pdf->SetXY(15, $y);
$pdf->Cell(15, 7, $lang['pdf_no'], 1, 0, 'L', true);
$pdf->Cell(80, 7, $lang['pdf_customer'], 1, 0, 'L', true);
$pdf->Cell(40, 7, $lang['pdf_borrow_date'], 1, 0, 'L', true);
$pdf->Cell(30, 7, $lang['pdf_status'], 1, 0, 'L', true);
$pdf->Cell(45, 7, $lang['pdf_due_date'], 1, 0, 'L', true);
$pdf->Cell(60, 7, $lang['pdf_return_date'], 1, 1, 'L', true);

$y += 7;

$get_transactions = "SELECT DISTINCT C.`name`, C.`phone_number`, B.`title`, B.`author`, B.`isbn`, BR.`id`, BR.`borrow_date`, BR.`status`, BR.`due_date`, BR.`return_date`, BR.`added_date` FROM `borrowing` BR INNER JOIN `books` B ON B.`isbn` = BR.`book_isbn` INNER JOIN `customers` C ON BR.`customer_id` = C.`id` WHERE B.`status` NOT IN ('deleted') AND BR.`due_date` < CURDATE()";
$transactions = $GLOBALS['conn']->query($get_transactions);
$num = 1;

if ($transactions->num_rows > 0) {
    while ($row = $transactions->fetch_assoc()) {
        $id = $row['id'];
        $title = $row['title'];
        $isbn = $row['isbn'];
        $author = $row['author'];
        $customer = $row['name'];
        $phone_number = $row['phone_number'];
        $borrow_date = new DateTime($row['borrow_date']);
        $due_date = new DateTime($row['due_date']);
        $status = $row['status'];
        $added_date = new DateTime($row['added_date']);
        $return_date = new DateTime($row['return_date']);
        $return_date1 = $row['return_date'];

        $statusTxt = ucwords($status);

        $added_date = $added_date->format('F d, Y');
        $borrow_date = $borrow_date->format('F d, Y');
        $due_date = $due_date->format('F d, Y');
        $return_date = $return_date->format('F d, Y');

        if ($return_date1 == '0000-00-00 00:00:00') {
            $return_date = '';
        }

        // Check if we need to add a new page
        if ($y + 7 > 180) { // Adjust this value based on your layout
            $pdf->AddPage();
            $pdf->SetFont('aefurat', '', 10);
            $y = 10; // Reset Y position after adding a new page

            // Re-add table header on the new page
            $pdf->SetFont('aefurat', 'B', 10);
            $pdf->SetXY(15, $y);
            $pdf->Cell(15, 7, $lang['pdf_no'], 1, 0, 'L', true);
            $pdf->Cell(80, 7, $lang['pdf_customer'], 1, 0, 'L', true);
            $pdf->Cell(40, 7, $lang['pdf_borrow_date'], 1, 0, 'L', true);
            $pdf->Cell(30, 7, $lang['pdf_status'], 1, 0, 'L', true);
            $pdf->Cell(45, 7, $lang['pdf_due_date'], 1, 0, 'L', true);
            $pdf->Cell(60, 7, $lang['pdf_return_date'], 1, 1, 'L', true);

            $y += 7;
        }

        // Add row
        $pdf->SetFont('aefurat', '', 10);
        $pdf->SetXY(15, $y);
        $pdf->Cell(15, 7, $num, 1, 0, 'L');
        $pdf->Cell(80, 7, $customer . ", " . $phone_number, 1, 0, 'L');
        $pdf->Cell(40, 7, $borrow_date, 1, 0, 'L');
        $pdf->Cell(30, 7, $statusTxt, 1, 0, 'L');
        $pdf->Cell(45, 7, $due_date, 1, 0, 'L');
        $pdf->Cell(60, 7, $return_date, 1, 1, 'L');
        
        $num++;
        $y += 7;
    }

    // Draw footer line on the last page
    $pdf->Rect(15, $y, 265, 0.1);
}

// Output the PDF
$pdf->Output($lang['pdf_overdue_books_report'] . ".pdf", 'I');
?>
