<?php 
// Create instance of FPDF
$pdf = new FPDF('L', 'mm', 'A4'); // 'L' for landscape orientation

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', '', 10);

// Add Logo
$pdf->Image('./assets/images/logo.png', 125, 5, 50); // Adjust size as needed

// Set header
$pdf->SetFillColor(163, 185, 67);
$pdf->SetDrawColor(163, 185, 67);
$pdf->Rect(15, 40, 270, 0.2); // Adjusted position and width for landscape

$pdf->SetFont('Arial', 'B', 13);
$pdf->SetXY(15, 45);
$pdf->Cell(0, 10, "All Books Report", 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(15, 50);
$pdf->Cell(0, 10, "Print Date: " . date('F d, Y h:i:s A'), 0, 1, 'C');

$y = 60;

// Table Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY(15, $y);
$pdf->Cell(15, 7, "No.", 1, 0, 'L', true);
$pdf->Cell(80, 7, "Title", 1, 0, 'L', true);
$pdf->Cell(35, 7, "ISBN", 1, 0, 'L', true);
$pdf->Cell(65, 7, "Author", 1, 0, 'L', true);
$pdf->Cell(30, 7, "Published", 1, 0, 'L', true);
$pdf->Cell(40, 7, "Category", 1, 1, 'L', true);

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
        if ($y + 7 > 180) { // 290mm is used to account for margins
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            $y = 10; // Reset Y position after adding a new page

            // Re-add table header on the new page
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(15, $y);
            $pdf->Cell(15, 7, "No.", 1, 0, 'L', true);
            $pdf->Cell(80, 7, "Title", 1, 0, 'L', true);
            $pdf->Cell(35, 7, "ISBN", 1, 0, 'L', true);
            $pdf->Cell(65, 7, "Author", 1, 0, 'L', true);
            $pdf->Cell(30, 7, "Published", 1, 0, 'L', true);
            $pdf->Cell(40, 7, "Category", 1, 1, 'L', true);

            $y += 7;
        }

        // Add row
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(15, $y);
        $pdf->Cell(15, 7, $num, 1, 0, 'L');
        $pdf->Cell(80, 7, $title, 1, 0, 'L');
        $pdf->Cell(35, 7, $isbn, 1, 0, 'L');
        $pdf->Cell(65, 7, $author, 1, 0, 'L');
        $pdf->Cell(30, 7, $published_year, 1, 0, 'L');
        $pdf->Cell(40, 7, $category, 1, 1, 'L');

        $num ++;
        $y += 7;
    }

    // Draw footer line on the last page
    $pdf->Rect(15, $y, 265, 0.1);
}

// Output the PDF
$pdf->Output();
?>
