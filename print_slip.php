<?php
require('fpdf/fpdf.php'); // 📌 ต้องมีไลบรารี FPDF (โหลดฟรีได้ที่ https://www.fpdf.org/)
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$month = $_GET['month'] ?? date('Y-m');

// ✅ ดึงข้อมูลผู้ใช้
$user = $conn->query("SELECT id FROM users WHERE username='$username'")->fetch_assoc();
$user_id = $user['id'];

// ✅ ดึงข้อมูลเดือนที่เลือก
$data = $conn->query("
    SELECT SUM(income) AS total_income, SUM(tax) AS total_tax, SUM(net_salary) AS total_net 
    FROM history 
    WHERE user_id='$user_id' AND DATE_FORMAT(created_at, '%Y-%m') = '$month'
")->fetch_assoc();

// ✅ กำหนดค่า
$income = number_format($data['total_income'] ?? 0, 2);
$tax = number_format($data['total_tax'] ?? 0, 2);
$net = number_format($data['total_net'] ?? 0, 2);
$date = date("d/m/Y");

// ✅ ตั้งค่าสลิป
class PDF extends FPDF {
    function Header() {
        // โลโก้บริษัท (ใส่โลโก้ตัวอย่าง)
        $this->Image('https://upload.wikimedia.org/wikipedia/commons/6/6b/Check_green_icon.svg', 10, 8, 20);
        $this->SetFont('Arial','B',18);
        $this->Cell(0,10,iconv('UTF-8','TIS-620','บริษัท โครงงานคำนวณภาษีและเงินเดือนสุทธิ จำกัด'),0,1,'C');
        $this->Ln(5);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,iconv('UTF-8','TIS-620','รายงานสรุปภาษีและเงินเดือนประจำเดือน'),0,1,'C');
        $this->Ln(5);
        $this->Line(10, 35, 285, 35); // เส้นคั่น
    }
}

// ✅ ตั้งค่าหน้า PDF แนวนอน (A4)
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();

// ✅ หัวข้อหลัก
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,10,iconv('UTF-8','TIS-620','ชื่อผู้ใช้: '.$username),0,1,'L');
$pdf->Cell(0,10,iconv('UTF-8','TIS-620','เดือนที่รายงาน: '.$month),0,1,'L');
$pdf->Cell(0,10,iconv('UTF-8','TIS-620','วันที่ออกรายงาน: '.$date),0,1,'L');
$pdf->Ln(5);

// ✅ ตารางสรุป
$pdf->SetFont('Arial','B',14);
$pdf->Cell(95,12,iconv('UTF-8','TIS-620','รายการ'),1,0,'C');
$pdf->Cell(95,12,iconv('UTF-8','TIS-620','จำนวน (บาท)'),1,1,'C');

$pdf->SetFont('Arial','',13);
$pdf->Cell(95,12,iconv('UTF-8','TIS-620','รายได้รวม'),1,0,'L');
$pdf->Cell(95,12,iconv('UTF-8','TIS-620',$income),1,1,'R');

$pdf->Cell(95,12,iconv('UTF-8','TIS-620','ภาษีรวม'),1,0,'L');
$pdf->Cell(95,12,iconv('UTF-8','TIS-620',$tax),1,1,'R');

$pdf->Cell(95,12,iconv('UTF-8','TIS-620','เงินเดือนสุทธิ'),1,0,'L');
$pdf->Cell(95,12,iconv('UTF-8','TIS-620',$net),1,1,'R');

$pdf->Ln(20);

// ✅ ลายเซ็น
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,10,iconv('UTF-8','TIS-620','ลงชื่อ......................................................'),0,1,'R');
$pdf->Cell(0,10,iconv('UTF-8','TIS-620','( ผู้ตรวจสอบข้อมูล )'),0,1,'R');

// ✅ แสดงผล PDF
$pdf->Output('I', "Slip_$month.pdf");
?>
