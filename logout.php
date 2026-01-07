<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ออกจากระบบ | Tax Calculator</title>

<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Prompt', sans-serif;
    background: linear-gradient(135deg, #6c5ce7, #00cec9);
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.logout-box {
    background: rgba(255,255,255,0.95);
    padding: 60px 70px;
    border-radius: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.25);
    text-align: center;
    animation: popUp 0.7s ease;
    max-width: 420px;
}

.circle {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #74b9ff, #00cec9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 55px;
    animation: pulse 2s infinite;
}

h2 {
    color: #00b894;
    margin-bottom: 10px;
}

p {
    color: #2d3436;
    margin-bottom: 25px;
}

a {
    text-decoration: none;
    color: white;
    background: linear-gradient(135deg, #0984e3, #00cec9);
    padding: 12px 25px;
    border-radius: 10px;
    font-weight: 500;
    display: inline-block;
    transition: 0.3s;
}

a:hover {
    transform: scale(1.05);
}

.footer {
    margin-top: 25px;
    font-size: 13px;
    color: #636e72;
}

@keyframes popUp {
    from {opacity: 0; transform: translateY(25px);}
    to {opacity: 1; transform: translateY(0);}
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>

<!-- ⏳ กลับไปหน้า login ใน 3 วินาที -->
<meta http-equiv="refresh" content="3;url=login.php">

</head>
<body>

<div class="logout-box">
    <div class="circle">🚪</div>
    <h2>ออกจากระบบสำเร็จ</h2>
    <p>ระบบจะพาคุณกลับไปยังหน้าเข้าสู่ระบบภายใน <strong>3 วินาที</strong></p>
    <a href="login.php">กลับไปหน้าเข้าสู่ระบบทันที</a>

    <div class="footer">
        © <?= date("Y"); ?> Tax Calculator
    </div>
</div>

</body>
</html>
