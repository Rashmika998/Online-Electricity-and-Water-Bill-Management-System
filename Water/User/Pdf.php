<?php
require '../../Config.php';
require '../../fpdf/fpdf.php';
$uid = $_GET['user_id'];
$month = $_GET['month'];

$result =  mysqli_query($link, "SELECT * FROM water_bill WHERE user_id = $uid AND month= '$month'");
$data_bill = mysqli_fetch_assoc($result);

$result_arr =  mysqli_query($link, "SELECT * FROM water_pay WHERE user_id = $uid AND month= '$month'");
$data_bill_arr = mysqli_fetch_assoc($result_arr);

$res =  mysqli_query($link, "SELECT * FROM water_details WHERE user_id = $uid");
$data = mysqli_fetch_assoc($res);
$name = ': ' . $data['name'];
$address = ': ' . $data['user_address'];
$acc = ': ' . $data['user_account'];
$umeter = ': ' . $data['user_meter'];
$month = ': ' . $data_bill['month'];
$meter = ': ' . $data_bill['meter'];
$units = ': ' . $data_bill['units'];
$arrear = ': ' . $data_bill_arr['arrear'] . '/=';
$charge = ': Rs.' . $data_bill['charge'] . '/=';
$total = ': Rs.' . $data_bill['total'] . '/=';
$due = ': ' . $data_bill['due'];
$updated = ': ' . $data_bill['updated_at'];

$pdf = new FPDF('p', 'mm', 'A4');
$pdf->AddPage();
$pdf->Rect(7, 7, 197, 287, 'D'); //For A4
$pdf->Image('../../images/water_bill.png', 15, 15, 35, 35);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Ln();
$pdf->Cell(0, 10, 'National Water Supply and Drainage Board', 0, 1, 'C');
$pdf->Ln();
$pdf->Cell(0, 10, 'Statement of Water Account', 0, 1, 'C');
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '  PERSONAL DETAILS', 1, 1, 'L');
$pdf->ln(6);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 8, 'Name', 0, 0, 'L');
$pdf->Cell(40, 8, $name, 0, 1, 'L');
$pdf->Cell(40, 8, 'Address', 0, 0, 'L');
$pdf->Cell(40, 8, $address, 0, 1, 'L');
$pdf->Cell(40, 8, 'Meter Number', 0, 0, 'L');
$pdf->Cell(40, 8, $umeter, 0, 1, 'L');
$pdf->Cell(40, 8, 'Account Number', 0, 0, 'L');
$pdf->Cell(40, 8, $acc, 0, 1, 'L');
$pdf->Ln();
$pdf->Ln();
$pdf->SetLeftMargin(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '  BILL DETAILS', 1, 1, 'L');
$pdf->ln(6);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(60, 8, 'Month', 0, 0, 'L');
$pdf->Cell(40, 8, $month, 0, 1, 'L');
$pdf->Cell(60, 8, 'Meter', 0, 0, 'L');
$pdf->Cell(40, 8, $meter, 0, 1, 'L');
$pdf->Cell(60, 8, 'Arrears from previous month', 0, 0, 'L');
$pdf->Cell(40, 8, $arrear, 0, 1, 'L');
$pdf->Cell(60, 8, 'Units Consumed for the month', 0, 0, 'L');
$pdf->Cell(40, 8, $units, 0, 1, 'L');
$pdf->Cell(60, 8, 'Charge for the Month (Rs.)', 0, 0, 'L');
$pdf->Cell(40, 8, $charge, 0, 1, 'L');
$pdf->Cell(60, 8, 'Total Amount Due (Rs.)', 0, 0, 'L');
$pdf->Cell(40, 8, $total, 0, 1, 'L');
$pdf->Cell(60, 8, 'Pay Before', 0, 0, 'L');
$pdf->Cell(40, 8, $due, 0, 1, 'L');

$pdf->ln(8);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, '  ISSUING DETAILS', 1, 1, 'L');
$pdf->ln(6);
$pdf->SetLeftMargin(20);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 8, 'Date of Issue', 0, 0, 'L');
$pdf->Cell(40, 8, $updated, 0, 1, 'L');
$pdf->SetY(260);
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
$pdf->Output();
