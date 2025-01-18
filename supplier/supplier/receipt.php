<?php
// Ensure the correct path to TCPDF and other required files
require_once '../../golfer/vendor/autoload.php';
require_once 'dbconnect.php';

// Start session to access session variables
session_start();

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
$pdf->Cell(0, 10, 'SUPPLIER PAYMENT RECEIPT', 0, 1, 'C');

$id = isset($_GET['id']) ? $_GET['id'] : '';
$session_id = isset($_GET['session_id']) ? $_GET['session_id'] : '';


$transactionDate = date('Y-m-d H:i:s'); // Example transaction date

$query = mysqli_query($dbcon, "SELECT surname, othernames FROM userlogin WHERE staffid = '$session_id'") or die(mysqli_error($dbcon));
$supplier = mysqli_fetch_array($query);
$supplierName = isset($supplier['surname']) ? $supplier['surname'] . ' ' . (isset($supplier['othernames']) ? $supplier['othernames'] : '') : 'Unknown Supplier';


// Content
$html = '<p><strong>Date:</strong> ' . $transactionDate . '</p>';
//$html .= '<p><strong>Customer ID:</strong> ' . $id . '</p>';
$html .= '<p><strong>Supplier Name:</strong> ' . $supplierName . '</p>';
// Fetch payment details and products from database
$sql = "SELECT requested_kit.*, golf_tools.*, saveSupply.* 
                            FROM requested_kit
                            JOIN golf_tools ON requested_kit.kitId = golf_tools.kitId
                            JOIN saveSupply ON saveSupply.requestId = requested_kit.requestId
                            WHERE requested_kit.isUpdated = 1
                            AND saveSupply.payment = 1
                            AND saveSupply.supPayment = 1
                            AND golf_tools.supplyId = '$session_id'
                            AND saveSupply.supplyId = '$id'";

$results = mysqli_query($dbcon, $sql);

// Initialize variables for subtotal and total
$total = 0;

if (mysqli_num_rows($results) > 0) {
    // Start table
    $html .= '<table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px; width: 100%;">';

    // Table header
    $html .= '<tr>';
    $html .= '<th style="text-align: left;">Golf kit(s)</th>';
    $html .= '<th style="text-align: center;">Price</th>';
    $html .= '<th style="text-align: center;">Amount (each)</th>';
    $html .= '<th style="text-align: center;">Subtotal</th>';
    $html .= '</tr>';

    // Fetch data and populate table rows
    while ($row = mysqli_fetch_assoc($results)) {
        $tool_name = explode(',', $row['tool_name']);
        $quantity = explode(',', $row['quantity']);
        $amount = explode(',', $row['quantity_each']);

        $html .= '<tr>';
        $html .= '<td>';
        foreach ($tool_name as $tees) {
            $html .= $tees . '<br>';
        }
        $html .= '</td>';

        $html .= '<td style="text-align: center;">';
        foreach ($quantity as $price) {
            $html .= 'Kshs ' . number_format((float)$price, 2) . '<br>';
        }
        $html .= '</td>';

        $html .= '<td style="text-align: center;">';
        foreach ($amount as $hol) {
            $html .= 'Kshs ' . number_format((float)$hol, 2) . '<br>';
        }
        $html .= '</td>';

        // Calculate subtotal and total
        $subtotal = 0;
        foreach ($quantity as $key => $price) {
            $subtotal += (float)$price * (int)$amount[$key];
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
$pdf->Output('receipt_' . $session_id . '.pdf', 'I');
