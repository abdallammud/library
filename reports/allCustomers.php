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
$pdf->Cell(0, 10, "All Customers Report", 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(15, 50);
$pdf->Cell(0, 10, "Print Date: " . date('F d, Y h:i:s A'), 0, 1, 'C');

$y = 60;

// Table Header
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetXY(15, $y);
$pdf->Cell(15, 7, "No.", 1, 0, 'L', true);
$pdf->Cell(80, 7, "Name", 1, 0, 'L', true);
$pdf->Cell(40, 7, "Phone", 1, 0, 'L', true);
$pdf->Cell(60, 7, "Email", 1, 0, 'L', true);
$pdf->Cell(30, 7, "Status", 1, 0, 'L', true);
$pdf->Cell(40, 7, "Date Joined", 1, 1, 'L', true);

$y += 7;

$get_customers = "SELECT * FROM `customers` WHERE `membership_status` != 'deleted' ";
$customers = $GLOBALS['conn']->query($get_customers);
$num = 1;
if ($customers->num_rows > 0) {
    while ($row = $customers->fetch_assoc()) {
        $id = $row['id'];
		$name = $row['name'];
		$email = $row['email'];
		$phone_number = $row['phone_number'];
		
		$membership_status 	= $row['membership_status'];
		$added_date = new dateTime($row['added_date']);
		$added_date = $added_date->format('F d Y');
        // Check if we need to add a new page
        if ($y + 7 > 180) { // 290mm is used to account for margins
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 10);
            $y = 10; // Reset Y position after adding a new page

            // Re-add table header on the new page
            $pdf->SetFont('Arial', 'B', 10);
           	$pdf->SetXY(15, $y);
           	$pdf->Cell(15, 7, "No.", 1, 0, 'L', true);
			$pdf->Cell(80, 7, "Name", 1, 0, 'L', true);
			$pdf->Cell(40, 7, "Phone", 1, 0, 'L', true);
			$pdf->Cell(60, 7, "Email", 1, 0, 'L', true);
			$pdf->Cell(30, 7, "Status", 1, 0, 'L', true);
			$pdf->Cell(40, 7, "Date Joined", 1, 1, 'L', true);

            $y += 7;
        }

        // Add row
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(15, $y);
        $pdf->Cell(15, 7, $num, 1, 0, 'L');
        $pdf->Cell(80, 7, $name, 1, 0, 'L');
        $pdf->Cell(40, 7, $phone_number, 1, 0, 'L');
        $pdf->Cell(60, 7, $email, 1, 0, 'L');
        $pdf->Cell(30, 7, $membership_status, 1, 0, 'L');
        $pdf->Cell(40, 7, $added_date, 1, 1, 'L');
        $num++;
        $y += 7;
    }

    // Draw footer line on the last page
    $pdf->Rect(15, $y, 265, 0.1);
}

// Output the PDF
$pdf->Output();
?>
