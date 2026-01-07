<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$user_id = $conn->query("SELECT id FROM users WHERE username='$username'")
                ->fetch_assoc()['id'];

$selectedYear  = $_GET['year'] ?? '';
$selectedMonth = $_GET['month'] ?? '';
$selectedDay   = $_GET['day'] ?? '';

if (isset($_GET['delete'])) {
    $monthToDelete = $_GET['delete'];
    $conn->query("DELETE FROM history 
                  WHERE user_id='$user_id' 
                  AND DATE_FORMAT(created_at, '%Y-%m') = '$monthToDelete'");
    header("Location: dashboard.php");
    exit();
}

$where = "WHERE user_id='$user_id'";
if ($selectedYear)  $where .= " AND YEAR(created_at) = '$selectedYear'";
if ($selectedMonth) $where .= " AND DATE_FORMAT(created_at, '%Y-%m') = '$selectedMonth'";
if ($selectedDay)   $where .= " AND DATE_FORMAT(created_at, '%Y-%m-%d') = '$selectedDay'";

$sql = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month,
               SUM(income) AS total_income,
               SUM(tax) AS total_tax,
               SUM(net_salary) AS total_net
        FROM history
        $where
        GROUP BY DATE_FORMAT(created_at, '%Y-%m')
        ORDER BY month ASC";
$result = $conn->query($sql);

$totalQuery = "SELECT SUM(income) AS total_income,
                      SUM(tax) AS total_tax,
                      SUM(net_salary) AS total_net
               FROM history
               $where";
$yearTotal = $conn->query($totalQuery)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>Dashboard ระบบคำนวณเงินเดือนสุทธิ</title>

<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Prompt', sans-serif;
    background: #f3f6fb;
    margin: 0;
    padding: 0;
}

.container {
    width: 95%;
    max-width: 1200px;
    margin: 50px auto;
    background: #ffffff;
    border-radius: 15px;
    padding: 30px 40px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

h2 {
    text-align: center;
    color: #004aad;
    margin-bottom: 5px;
    font-size: 28px;
}

p {
    text-align: center;
    color: #374151;
    margin-bottom: 25px;
}

.nav {
    text-align: center;
    margin-bottom: 25px;
}

.nav a {
    display: inline-block;
    margin: 0 8px;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 500;
    color: #fff;
    text-decoration: none;
    background: linear-gradient(90deg,#0066cc,#003366);
    transition: 0.3s;
}

.nav a:hover {
    background: linear-gradient(90deg,#003366,#001f4d);
}

.summary {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 30px;
}

.card {
    flex: 1 1 28%;
    background: #f0f4f8;
    border-left: 5px solid #0066cc;
    padding: 20px;
    border-radius: 12px;
    text-align: center;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}

.card h3 {
    color: #004aad;
    margin-bottom: 10px;
    font-size: 18px;
}

.card p {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
}

.table-container {
    overflow-x: auto;
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: center;
}

th {
    background: #004aad;
    color: #fff;
    font-weight: 500;
}

tr:nth-child(even) {
    background: #f9fafb;
}

tr:hover {
    background: #e6f0ff;
}

.btn-delete {
    background: #e53935;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
}

.btn-delete:hover {
    background: #b71c1c;
}

.footer {
    text-align: center;
    color: #6b7280;
    font-size: 14px;
    margin-top: 30px;
}
</style>
</head>

<body>
<div class="container">

<h2>📊 คำนวณภาษีและเงินเดือนสุทธิ</h2>
<p>ยินดีต้อนรับ, <strong><?= htmlspecialchars($username) ?></strong></p>

<div class="nav">
    <a href="calculate.php">➕ คำนวณใหม่</a>
    <a href="profile.php">👤 โปรไฟล์ของฉัน</a>

    </a>
</div>

<div class="summary">
    <div class="card">
        <h3>รายได้รวม</h3>
        <p><?= number_format($yearTotal['total_income'] ?? 0, 2) ?> บาท</p>
    </div>
    <div class="card">
        <h3>ภาษีรวม</h3>
        <p><?= number_format($yearTotal['total_tax'] ?? 0, 2) ?> บาท</p>
    </div>
    <div class="card">
        <h3>เงินสุทธิรวม</h3>
        <p><?= number_format($yearTotal['total_net'] ?? 0, 2) ?> บาท</p>
    </div>
</div>

<div class="table-container">
<table>
    <tr>
        <th>เดือน</th>
        <th>รายได้รวม (บาท)</th>
        <th>ภาษีรวม (บาท)</th>
        <th>เงินสุทธิรวม (บาท)</th>
        <th>จัดการ</th>
    </tr>

<?php if ($result->num_rows > 0): ?>
<?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['month'] ?></td>
        <td><?= number_format($row['total_income'], 2) ?></td>
        <td><?= number_format($row['total_tax'], 2) ?></td>
        <td><?= number_format($row['total_net'], 2) ?></td>
        <td>
            <a href="dashboard.php?delete=<?= $row['month'] ?>"
               class="btn-delete"
               onclick="return confirm('ลบข้อมูลเดือนนี้?')">
               ลบ
            </a>
        </td>
    </tr>
<?php endwhile; ?>

    <!-- 🔹 แถวสรุปรวมทั้งปี -->
    <tr style="background:#e6f0ff;font-weight:600;">
        <td>รวมทั้งปี</td>
        <td><?= number_format($yearTotal['total_income'] ?? 0, 2) ?></td>
        <td><?= number_format($yearTotal['total_tax'] ?? 0, 2) ?></td>
        <td><?= number_format($yearTotal['total_net'] ?? 0, 2) ?></td>
        <td>-</td>
    </tr>

<?php else: ?>
    <tr>
        <td colspan="5">ยังไม่มีข้อมูล</td>
    </tr>
<?php endif; ?>
</table>
</div>


<div class="footer">
    © <?= date("Y") ?> ระบบคำนวณภาษีและเงินเดือน | พัฒนาโดยนักศึกษา ปวส.
</div>

</div>
</body>
</html>
