<?php
require '../../Config.php';
require '../../fpdf/fpdf.php';
$uid= $_GET['user_id'];
$month = $_GET['month'];
$result =  mysqli_query($link,"SELECT * FROM water_bill WHERE user_id = $uid AND month= '$month'");
$data_bill=mysqli_fetch_assoc($result);

$res =  mysqli_query($link,"SELECT * FROM water_details WHERE user_id = $uid");
$data=mysqli_fetch_assoc($res);
$name = 'Name : '.$data['name'];
$address = 'Address : '.$data['user_address'];
$acc = 'Electricity Account Number : '.$data['user_account'];
$area = 'Area Office : '.$data['user_area'];
$pre = 'Premises ID : '.$data['user_premises'];
$month = 'Bill Month : '.$data_bill['month'];
$meter = 'Meter: '.$data_bill['meter'];
$units = 'Units Consumed for the month: '.$data_bill['units'];
$charge = 'Charge for the Month : Rs.'.$data_bill['charge'].'/=';
$total = 'Total Amount Due : Rs.'.$data_bill['total'].'/=';
$due = 'Pay Before : '.$data_bill['due'];

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Image("../../images/ceb_bill.png");
    $pdf->Cell(50,12,'',0);
    $pdf->Cell(100,0,'Ceylon Electricity Board Statement of Electricity Account',0,0,'C');
    $pdf->Ln();
    $pdf->SetFont('Arial','',12);
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(50,12,$name,0);
    $pdf->Ln();
    $pdf->Cell(50,12,$address,0);
    $pdf->Ln();
    $pdf->Cell(50,12,$area,0);
    $pdf->Ln();
    $pdf->Cell(100,12,$acc,0);
    $pdf->Cell(100,12,$pre,0);
    $pdf->Ln();
    $pdf->Cell(50,12,$month,0);
    $pdf->Ln();
    $pdf->Cell(100,12,$meter,0);
    $pdf->Cell(50,12,$units,0);
    $pdf->Ln();
    $pdf->Cell(100,12,$charge,0);
    $pdf->Cell(80,12,$total,0);
    $pdf->Ln();
    $pdf->Cell(50,12,$due,0);
    $pdf->SetY(260);
    $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
    $pdf->Output();
// foreach($header as $heading) {
// 	foreach($heading as $column_heading)
// 		$pdf->Cell(25,12,$column_heading,1);
// }
// foreach($result as $row) {
// 
// 	foreach($row as $column)
// 		$pdf->Cell(25,12,$column,1);
// }

?>