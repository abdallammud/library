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
$pdf->SetTitle('Document Title');
$pdf->SetSubject('Document Subject');

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
$pdf->Cell(0, 10, $lang['pdf_all_books_report'], 0, 1, 'C');

$pdf->SetFont('aefurat', '', 10);
$pdf->SetXY(15, 50);
$pdf->Cell(0, 10, $lang['pdf_print_date'] . date('F d, Y h:i:s A'), 0, 1, 'C');

$y = 60;

// Table Header
$pdf->SetFont('aefurat', 'B', 10);
$pdf->SetXY(15, $y);
$pdf->Cell(15, 7, $lang['pdf_no'], 1, 0, 'L', true);
$pdf->Cell(80, 7, $lang['pdf_title'], 1, 0, 'L', true);
$pdf->Cell(35, 7, $lang['pdf_isbn'], 1, 0, 'L', true);
$pdf->Cell(65, 7, $lang['pdf_author'], 1, 0, 'L', true);
$pdf->Cell(30, 7, $lang['pdf_published'], 1, 0, 'L', true);
$pdf->Cell(40, 7, $lang['pdf_category'], 1, 1, 'L', true);

$y += 7;

$get_books = "SELECT `book_id`, `title`, `author`, `publisher`, `published_year`, B.`status`, `isbn`, `category_id`, B.`added_date`, `name` FROM `books` B INNER JOIN `categories` C ON C.`id` = B.`category_id` WHERE B.`status` NOT IN ('deleted')";
$books = $GLOBALS['conn']->query($get_books);
$num = 1;

if ($books->num_rows > 0) {
    while ($row = $books->fetch_assoc()) {
        $book_id = $row['book_id'];
        $title = $row['title'];
        $isbn = $row['isbn'];
        $author = $row['author'];
        $category_id = $row['category_id'];
        $publisher = $row['publisher'];
        $published_year = $row['published_year'];
        $status = $row['status'];
        $added_date = new DateTime($row['added_date']);

        $statusTxt = ucwords($status);
        if (strtolower($status) == 'active') $statusTxt = 'Available';

        $added_date = $added_date->format('F d, Y');
        $category = $row['name'];

        // Check if we need to add a new page
        if ($y + 7 > 180) { // Adjust this value based on your layout
            $pdf->AddPage();
            $pdf->SetFont('aefurat', '', 10);
            $y = 10; // Reset Y position after adding a new page

            // Re-add table header on the new page
            $pdf->SetFont('aefurat', 'B', 10);
            $pdf->SetXY(15, $y);
            $pdf->Cell(15, 7, $lang['pdf_no'], 1, 0, 'L', true);
            $pdf->Cell(80, 7, $lang['pdf_title'], 1, 0, 'L', true);
            $pdf->Cell(35, 7, $lang['pdf_isbn'], 1, 0, 'L', true);
            $pdf->Cell(65, 7, $lang['pdf_author'], 1, 0, 'L', true);
            $pdf->Cell(30, 7, $lang['pdf_published'], 1, 0, 'L', true);
            $pdf->Cell(40, 7, $lang['pdf_category'], 1, 1, 'L', true);

            $y += 7;
        }

        // Add row
        $pdf->SetFont('aefurat', '', 10);
        $pdf->SetXY(15, $y);
        $pdf->Cell(15, 7, $num, 1, 0, 'L');
        $pdf->Cell(80, 7, $title, 1, 0, 'L');
        $pdf->Cell(35, 7, $isbn, 1, 0, 'L');
        $pdf->Cell(65, 7, $author, 1, 0, 'L');
        $pdf->Cell(30, 7, $published_year, 1, 0, 'L');
        $pdf->Cell(40, 7, $category, 1, 1, 'L');

        $num++;
        $y += 7;
    }

    // Draw footer line on the last page
    $pdf->Rect(15, $y, 265, 0.1);
}

// Output the PDF
$pdf->Output($lang['pdf_all_books_report'].".pdf", 'I');
?>
