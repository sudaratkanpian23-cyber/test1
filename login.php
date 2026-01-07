<?php
include 'db.php';
session_start();

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบ | Tax Calculator</title>

<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

<style>
* {
    box-sizing: border-box;
    font-family: 'Prompt', sans-serif;
}

body {
    margin: 0;
    height: 100vh;
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

/* เอฟเฟกต์พื้นหลัง */
.bg-blur {
    position: absolute;
    width: 450px;
    height: 450px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    filter: blur(120px);
}

.blur1 { top: -120px; left: -120px; }
.blur2 { bottom: -120px; right: -120px; }

/* กล่องล็อกอิน */
.login-box {
    position: relative;
    z-index: 2;
    background: rgba(255,255,255,0.95);
    width: 400px;
    padding: 45px 45px 40px;
    border-radius: 22px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.25);
    animation: slideUp 0.8s ease;
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.login-box h2 {
    text-align: center;
    margin-bottom: 10px;
    color: #1e3a8a;
    font-weight: 600;
}

.login-box .subtitle {
    text-align: center;
    font-size: 14px;
    color: #64748b;
    margin-bottom: 30px;
}

/* input */
.input-group {
    margin-bottom: 18px;
}

.input-group input {
    width: 100%;
    padding: 13px 15px;
    border-radius: 10px;
    border: 1.8px solid #cbd5e1;
    font-size: 15px;
    transition: 0.3s;
}

.input-group input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
}

/* ปุ่ม */
button {
    width: 100%;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    border: none;
    color: #fff;
    padding: 13px;
    font-size: 16px;
    border-radius: 12px;
    cursor: pointer;
    margin-top: 10px;
    font-weight: 500;
    transition: 0.3s;
}

button:hover {
    background: linear-gradient(135deg, #1d4ed8, #2563eb);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(37,99,235,0.4);
}

/* ข้อความแจ้งเตือน */
.msg {
    margin-top: 18px;
    padding: 10px;
    background: #fee2e2;
    color: #b91c1c;
    border-radius: 8px;
    font-size: 14px;
}

/* footer */
.footer {
    margin-top: 30px;
    text-align: center;
    font-size: 13px;
    color: #64748b;
}

.footer a {
    color: #2563eb;
    text-decoration: none;
}

.footer a:hover {
    text-decoration: underline;
}

/* มือถือ */
@media (max-width: 480px) {
    .login-box {
        width: 90%;
        padding: 35px 25px;
    }
}
</style>
</head>

<body>

<div class="bg-blur blur1"></div>
<div class="bg-blur blur2"></div>

<div class="login-box">
    <h2>เข้าสู่ระบบ</h2>
    <div class="subtitle">ระบบคำนวณภาษีและเงินเดือนสุทธิ</div>

    <form method="post">
        <div class="input-group">
            <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="รหัสผ่าน" required>
        </div>

        <button type="submit" name="login">เข้าสู่ระบบ</button>
    </form>

    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $row['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<div class='msg'>รหัสผ่านไม่ถูกต้อง</div>";
            }
        } else {
            echo "<div class='msg'>ไม่พบชื่อผู้ใช้นี้</div>";
        }
    }
    ?>

    <div class="footer">
        © <?php echo date("Y"); ?> Tax Calculator  
        <br>ระบบคำนวณภาษีและเงินเดือนสุทธิ
    </div>
</div>

</body>
</html>
