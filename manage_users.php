<?php
include 'db.php';
session_start();

// ถ้ายังไม่ล็อกอินให้กลับไปหน้า login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// ดึงข้อมูลผู้ใช้ปัจจุบัน
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);
$currentUser = $result->fetch_assoc();

// ถ้าไม่ใช่ admin ให้กลับไปหน้า dashboard
if ($currentUser['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

// เพิ่มผู้ใช้ใหม่
if (isset($_POST['add_user'])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $new_role = $_POST['new_role'];

    $sql_add = "INSERT INTO users (username, password, role) VALUES ('$new_username', '$new_password', '$new_role')";
    if ($conn->query($sql_add) === TRUE) {
        echo "<p style='color:green'>เพิ่มผู้ใช้ใหม่เรียบร้อย!</p>";
    } else {
        echo "<p style='color:red'>เกิดข้อผิดพลาด: " . $conn->error . "</p>";
    }
}

// ลบผู้ใช้
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id='$delete_id'");
    echo "<p style='color:red'>ลบผู้ใช้เรียบร้อย</p>";
}

// ดึงรายชื่อผู้ใช้ทั้งหมด
$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<h2>จัดการผู้ใช้ (Admin)</h2>
<p>สวัสดี, <?php echo $username; ?> [Admin]</p>
<a href="dashboard.php">กลับไป Dashboard</a> | <a href="logout.php">ออกจากระบบ</a>

<h3>เพิ่มผู้ใช้ใหม่</h3>
<form method="post">
  <input type="text" name="new_username" placeholder="ชื่อผู้ใช้ใหม่" required>
  <input type="password" name="new_password" placeholder="รหัสผ่าน" required>
  <select name="new_role">
    <option value="user">ผู้ใช้ทั่วไป</option>
    <option value="admin">ผู้ดูแลระบบ</option>
  </select>
  <button type="submit" name="add_user">เพิ่ม</button>
</form>

<h3>รายชื่อผู้ใช้ทั้งหมด</h3>
<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <th>ID</th>
    <th>ชื่อผู้ใช้</th>
    <th>สิทธิ์</th>
    <th>วันที่สร้าง</th>
    <th>การจัดการ</th>
  </tr>

<?php while ($row = $users->fetch_assoc()) { ?>
  <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['username']; ?></td>
    <td><?php echo $row['role']; ?></td>
    <td><?php echo $row['created_at']; ?></td>
    <td>
      <?php if ($row['id'] != $currentUser['id']) { ?>
        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('ลบผู้ใช้นี้?')">ลบ</a>
      <?php } else { echo '-'; } ?>
    </td>
  </tr>
<?php } ?>
</table>