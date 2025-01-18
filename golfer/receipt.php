<?php
// Ensure the correct path to TCPDF and other required files
require_once 'vendor/autoload.php';
require_once 'dbconnect.php';

// Create new PDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Receipt');
$pdf->SetSubject('Receipt');

// Add a page
$pdf->AddPage();

// Set margins
$pdf->SetMargins(15, 15, 15); // left, top, right

// Logo (centered at the top)
$logo = 'kgu.jpeg'; // Adjust path to your logo
$logoWidth = 50; // Adjust width of the logo as necessary
$pageWidth = $pdf->getPageWidth();
$logoX = ($pageWidth - $logoWidth) / 2; // Calculate X position to center align

// Output the logo image
$pdf->Image($logo, $logoX, 15, $logoWidth, '', 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false);

// Company Information (centered below the logo)
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetY(70); // Adjust Y position as necessary
$pdf->Cell(0, 10, 'KENYA GOLF UNION', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 10, 'Email: info@kenyagolfunion.org | Phone: +254 123 456 789', 0, 1, 'C');
$pdf->Cell(0, 10, 'Location: Nairobi, Kenya', 0, 1, 'C');

// Divider line with black background
$pdf->SetFillColor(0); // Black color for fill
$pdf->Rect(15, $pdf->GetY() + 5, $pageWidth - 30, 1, 'F'); // Draw rectangle as divider

// Title for golfer information
$pdf->SetFont('helvetica', '', 14);
$pdf->Ln(10); // Line break
$pdf->Cell(0, 10, 'GOLFER PAYMENT RECEIPT', 0, 1, 'C');

// Customer details (replace with your actual logic to fetch from database)
$golferId = isset($_GET['golferId']) ? $_GET['golferId'] : '';
$firstName = isset($_GET['firstName']) ? $_GET['firstName'] : '';
$secondName = isset($_GET['secondName']) ? $_GET['secondName'] : '';


$transactionDate = date('Y-m-d H:i:s'); // Example transaction date

// Content
$html = '<p><strong>Date:</strong> ' . $transactionDate . '</p>';
$html .= '<p><strong>Customer ID:</strong> ' . $golferId . '</p>';
$html .= '<p><strong>Customer Name:</strong> ' . $firstName . ' ' . $secondName . '</p>';

// Fetch payment details and products from database
$sql = "SELECT booktee.*,
teetime.*,
golfer.*,
available_tees.*, payment.*,
GROUP_CONCAT(booktee.BookedHoles) AS allHoles,
GROUP_CONCAT(teetime.Price) AS allPrices,
GROUP_CONCAT(available_tees.tee_name) AS allTees
FROM booktee
JOIN teetime ON booktee.teeId = teetime.teeId
JOIN golfer ON booktee.golferId = golfer.golferId
JOIN payment ON payment.golferId = golfer.golferId
JOIN available_tees ON  teetime.availableTeeId = available_tees.id
WHERE booktee.golferId = '$golferId'
AND booktee.BookingStatus = 'approved'
AND DATE(payment.PaymentDate) = CURDATE()
AND booktee.isPaid = 'paid'
GROUP BY booktee.bookingId;";

$results = mysqli_query($dbcon, $sql);

// Initialize variables for subtotal and total
$total = 0;

if (mysqli_num_rows($results) > 0) {
    // Start table
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; width: 100%;">';

    // Table header
    $html .= '<tr>';
    $html .= '<th style="text-align: left;">Product</th>';
    $html .= '<th style="text-align: center;">Price</th>';
    $html .= '<th style="text-align: center;">Holes</th>';
    $html .= '<th style="text-align: center;">Subtotal</th>';
    $html .= '</tr>';

    // Fetch data and populate table rows
    while ($row = mysqli_fetch_assoc($results)) {
        $teetime = explode(',', $row['allTees']);
        $prices = explode(',', $row['allPrices']);
        $holes = explode(',', $row['allHoles']);

        $html .= '<tr>';
        $html .= '<td>';
        foreach ($teetime as $tees) {
            $html .= $tees . '<br>';
        }
        $html .= '</td>';

        $html .= '<td style="text-align: center;">';
        foreach ($prices as $price) {
            $html .= 'Kshs ' . number_format((float)$price, 2) . '<br>';
        }
        $html .= '</td>';

        $html .= '<td style="text-align: center;">';
        foreach ($holes as $hol) {
            $html .= $hol . '<br>';
        }
        $html .= '</td>';

        // Calculate subtotal and total
        $subtotal = 0;
        foreach ($prices as $key => $price) {
            $subtotal += (float)$price * (int)$holes[$key];
        }
        $total += $subtotal;

        $html .= '<td style="text-align: center;">Kshs ' . number_format($subtotal, 2) . '</td>';
        $html .= '</tr>';
    }

    // Total row
    $html .= '<tr>';
    $html .= '<td colspan="3" style="text-align: right;"><strong>Total:</strong></td>';
    $html .= '<td style="text-align: center;"><strong>Kshs ' . number_format($total, 2) . '</strong></td>';
    $html .= '</tr>';

    // Close table
    $html .= '</table>';
}

// Print text using writeHTML()
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF as a download
$pdf->Output('receipt_' . $golferId . '.pdf', 'D');
