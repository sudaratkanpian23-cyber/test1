<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$current_user = $_SESSION['username'];

// ดึง user_id ของผู้ login
$userQuery = $conn->query("SELECT id FROM users WHERE username='$current_user'");
$userRow = $userQuery->fetch_assoc();
$user_id = $userRow['id'];
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>คำนวณภาษีและเงินเดือนสุทธิ</title>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<style>
body {
    font-family: 'Prompt', sans-serif;
    background:#e0f2fe;
    display:flex;
    justify-content:center;
    padding:50px 0;
    margin:0;
}
.container {
    background:#fff;
    width:1000px;
    padding:40px 50px;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
}
.header {
    text-align:center;
    border-bottom:3px solid #1e3a8a;
    padding-bottom:10px;
    margin-bottom:25px;
}
.header h2 {
    color:#1e3a8a;
    margin:0;
}
.form {
    text-align:center;
    margin-bottom:30px;
}
input {
    width:50%;
    padding:12px;
    border-radius:10px;
    border:1px solid #cbd5e1;
    font-size:16px;
    margin-bottom:10px;
}
button {
    width:52%;
    padding:12px;
    border:none;
    border-radius:10px;
    color:white;
    background:linear-gradient(135deg,#2563eb,#1e40af);
    font-size:16px;
    cursor:pointer;
}
button:hover {
    box-shadow:0 4px 12px rgba(37,99,235,0.4);
}
.slip {
    border:2px solid #cbd5e1;
    border-radius:12px;
    padding:25px 40px;
    background:#f9fafb;
    margin-top:20px;
}
.slip h3 {
    text-align:center;
    color:#1e40af;
}
.table {
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}
.table th, .table td {
    border:1px solid #cbd5e1;
    padding:10px;
}
.table th {
    background:#e0e7ff;
}
.total {
    background:#dbeafe;
    font-weight:bold;
}
.footer {
    display:flex;
    justify-content:space-between;
    margin-top:30px;
}
.footer div {
    width:45%;
    text-align:center;
}
.footer p {
    border-top:1px solid #94a3b8;
    padding-top:6px;
}
.qr {
    text-align:right;
    margin-top:15px;
}
.print-btn {
    background:#16a34a;
    width:220px;
}
.back {
    display:block;
    text-align:center;
    margin-top:20px;
    text-decoration:none;
    color:#2563eb;
}

@media print {
    body * { visibility:hidden; }
    .slip, .slip * { visibility:visible; }
    .slip { position:absolute; top:0; left:0; width:100%; border:none; }
    button, .back { display:none; }
}
</style>
</head>

<body>

<div class="container">
    <div class="header">
        <h2>คำนวณภาษีและเงินเดือนสุทธิ</h2>
    </div>

    <div class="form">
        <form method="post">
            <input type="text" name="username_input" placeholder="ชื่อพนักงาน" required><br>
            <input type="date" name="selected_date" required><br>
            <input type="number" name="income" placeholder="รายได้ต่อเดือน (บาท)" required><br>
            <button type="submit" name="calculate">คำนวณ</button>
        </form>
    </div>

<?php
if (isset($_POST['calculate'])) {

    $income = floatval($_POST['income']);
    $selected_date = $_POST['selected_date'];
    $username_input = htmlspecialchars($_POST['username_input']);

    /* ===============================
   ภาษีเงินได้บุคคลธรรมดา (รายเดือน)
   อัตราโดยประมาณตามภาษีไทย
   =============================== */
if ($income <= 12500) {
    $tax_rate = 0;
} elseif ($income <= 25000) {
    $tax_rate = 0.05;
} elseif ($income <= 41666) {
    $tax_rate = 0.10;
} elseif ($income <= 62500) {
    $tax_rate = 0.15;
} elseif ($income <= 83333) {
    $tax_rate = 0.20;
} elseif ($income <= 166666) {
    $tax_rate = 0.25;
} elseif ($income <= 416666) {
    $tax_rate = 0.30;
} else {
    $tax_rate = 0.35;
}

$tax = $income * $tax_rate;


    /* ===============================
       ประกันสังคม (5% ไม่เกิน 750)
       =============================== */
    $social_security = min($income * 0.05, 750);

    /* ===============================
       เงินเดือนสุทธิ
       =============================== */
    $net_salary = $income - $tax - $social_security;

    echo "
    <div class='slip'>
        <h3>สลิปเงินเดือน</h3>

        <table class='table'>
            <tr>
                <th>ชื่อ</th><td>$username_input</td>
                <th>วันที่</th><td>".date('d/m/Y', strtotime($selected_date))."</td>
            </tr>
        </table>

        <table class='table'>
            <tr><th>รายการ</th><th>จำนวนเงิน (บาท)</th></tr>
            <tr><td>รายได้รวม</td><td align='right'>".number_format($income,2)."</td></tr>
            <tr><td>ภาษี (5%)</td><td align='right'>".number_format($tax,2)."</td></tr>
            <tr><td>ประกันสังคม</td><td align='right'>".number_format($social_security,2)."</td></tr>
            <tr class='total'><td>เงินเดือนสุทธิ</td><td align='right'>".number_format($net_salary,2)."</td></tr>
        </table>

        <div class='qr' id='qrcode'></div>

        <div class='footer'>
            <div>...............................<p>พนักงาน</p></div>
            <div>...............................<p>ผู้อนุมัติ</p></div>
        </div>

        <center>
            <button class='print-btn' onclick='window.print()'>🖨️ พิมพ์ / ดาวน์โหลด</button>
        </center>
    </div>";

    // บันทึกประวัติ
    $conn->query("INSERT INTO history (user_id, income, tax, net_salary, created_at)
                  VALUES ('$user_id','$income','$tax','$net_salary','$selected_date')");
}
?>

<a href="dashboard.php" class="back">← กลับหน้า Dashboard</a>
</div>

<script>
<?php if (isset($_POST['calculate'])): ?>
new QRCode(document.getElementById("qrcode"), {
    text: "รายได้ <?=number_format($income,2)?> | สุทธิ <?=number_format($net_salary,2)?>",
    width:90,
    height:90
});
<?php endif; ?>
</script>

</body>
</html>
