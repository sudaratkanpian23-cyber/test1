<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>สมัครสมาชิก | Tax Calculator</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body {
  font-family: 'Inter', sans-serif;
  background: #f0f2f5;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  margin: 0;
}

.register-box {
  background: #ffffff;
  border-radius: 16px;
  padding: 45px 50px;
  width: 420px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.12);
  text-align: center;
}

h2 {
  font-size: 26px;
  color: #1e272e;
  margin-bottom: 20px;
  font-weight: 700;
}

.icon {
  font-size: 55px;
  color: #2e86de;
  margin-bottom: 15px;
}

input {
  width: 100%;
  padding: 14px 16px;
  margin: 10px 0;
  border: 1px solid #dcdde1;
  border-radius: 10px;
  font-size: 15px;
}

input:focus {
  border-color: #2e86de;
  box-shadow: 0 0 10px rgba(46,134,222,0.2);
}

button {
  width: 100%;
  padding: 14px;
  margin-top: 18px;
  background: linear-gradient(135deg, #2e86de, #1e3799);
  border: none;
  color: white;
  font-weight: 600;
  font-size: 16px;
  border-radius: 10px;
  cursor: pointer;
}

.success, .error {
  margin-top: 18px;
  padding: 14px;
  border-radius: 8px;
  font-size: 14px;
  text-align: left;
}

.success {
  background: #e9f7ef;
  color: #27ae60;
  border-left: 5px solid #2ecc71;
}

.error {
  background: #fdecea;
  color: #c0392b;
  border-left: 5px solid #e74c3c;
}

.message {
  margin-top: 18px;
  font-size: 14px;
}
</style>
</head>

<body>
<div class="register-box">
  <div class="icon">🧾</div>
  <h2>สมัครสมาชิก</h2>

  <form method="post">
    <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
    <input type="email" name="email" placeholder="อีเมล" required>
    <input type="password" name="password" placeholder="รหัสผ่าน" required>
    <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน" required>
    <button type="submit" name="register">สร้างบัญชี</button>
  </form>

<?php
if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // ตรวจสอบรหัสผ่านตรงกัน
    if ($password !== $confirm) {
        echo "<div class='error'>❌ รหัสผ่านไม่ตรงกัน</div>";
    } else {

        // ตรวจสอบ username หรือ email ซ้ำ
        $check = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");
        if ($check->num_rows > 0) {
            echo "<div class='error'>⚠️ ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้งานแล้ว</div>";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password, role)
                    VALUES ('$username', '$email', '$hash', 'user')";

            if ($conn->query($sql) === TRUE) {
                echo "<div class='success'>✅ สมัครสมาชิกสำเร็จ!
                      <br><a href='login.php'>เข้าสู่ระบบ</a></div>";
            } else {
                echo "<div class='error'>❌ เกิดข้อผิดพลาด: {$conn->error}</div>";
            }
        }
    }
}
?>

  <div class="message">
    มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a>
  </div>
</div>
</body>
</html>
