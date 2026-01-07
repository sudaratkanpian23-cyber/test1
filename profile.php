<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// ดึงข้อมูลผู้ใช้รวม avatar
$sql = "SELECT username, email, role, avatar FROM users WHERE username='$username'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

/* Gravatar fallback */
$email = strtolower(trim($user['email']));
$hash = md5($email);
$avatar = $user['avatar'] ? $user['avatar'] : "https://www.gravatar.com/avatar/$hash?d=mp&s=200";
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>โปรไฟล์ผู้ใช้งาน | Tax Calculator</title>
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;500;600&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; font-family: 'Prompt', sans-serif; }
body {
    margin:0;
    background: linear-gradient(135deg, #e0f2fe, #f8fafc);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Card */
.profile-card {
    background: #ffffff;
    width:460px;
    border-radius:22px;
    box-shadow:0 30px 60px rgba(0,0,0,0.18);
    overflow:hidden;
    animation:fadeUp 0.8s ease;
}
@keyframes fadeUp { from{opacity:0; transform:translateY(25px);} to{opacity:1; transform:translateY(0);} }

/* Header */
.profile-header {
    background: linear-gradient(135deg,#2563eb,#3b82f6);
    padding: 35px 20px 70px;
    text-align:center;
    color:#fff;
    position:relative;
}
.profile-header h2 { margin:0; font-weight:600; }
.profile-header p { margin-top:6px; font-size:14px; opacity:0.9; }

/* Avatar */
.avatar {
    position:absolute;
    bottom:-50px;
    left:50%;
    transform:translateX(-50%);
    width:110px;
    height:110px;
}
.avatar img {
    width:100%;
    height:100%;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #3b82f6;
}

/* ไอคอน + overlay */
.upload-icon {
    position:absolute;
    bottom:0;
    right:0;
    background:#10b981;
    color:#fff;
    font-size:20px;
    width:32px;
    height:32px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:pointer;
    border:2px solid #fff;
    transition:0.3s;
}
.upload-icon:hover { background:#059669; transform:scale(1.2); }

/* Content */
.profile-body {
    padding:70px 35px 30px;
}
.info-row {
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    font-size:15px;
}
.info-row:last-child{border-bottom:none;}
.label{color:#64748b; font-weight:500;}
.value{color:#111827; font-weight:600;}

/* Buttons */
.actions {
    margin-top:30px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
}
.btn {
    padding:12px;
    border-radius:12px;
    text-align:center;
    text-decoration:none;
    font-weight:500;
    font-size:15px;
    transition:0.3s;
}
.btn-back{background:#e5e7eb;color:#111827;}
.btn-back:hover{background:#d1d5db;}
.btn-logout{background:#ef4444;color:#fff;}
.btn-logout:hover{background:#dc2626;}

/* Mobile */
@media(max-width:500px){.profile-card{width:92%;}}
</style>
</head>

<body>
<div class="profile-card">

    <div class="profile-header">
        <h2>โปรไฟล์ผู้ใช้งาน</h2>
        <p>ระบบคำนวณภาษีและเงินเดือนสุทธิ</p>

        <div class="avatar">
            <img src="<?= $avatar ?>" alt="Profile Image">
            <!-- ปุ่ม + overlay -->
            <label for="avatar" class="upload-icon">+</label>
            <form id="avatarForm" action="upload_avatar.php" method="post" enctype="multipart/form-data">
                <input type="file" name="avatar" id="avatar" accept="image/*" style="display:none;">
            </form>
        </div>
    </div>

    <div class="profile-body">

        <div class="info-row">
            <div class="label">ชื่อผู้ใช้</div>
            <div class="value"><?= htmlspecialchars($user['username']) ?></div>
        </div>

        <div class="info-row">
            <div class="label">อีเมล</div>
            <div class="value"><?= htmlspecialchars($user['email']) ?></div>
        </div>

        <div class="info-row">
            <div class="label">สิทธิ์ผู้ใช้งาน</div>
            <div class="value"><?= htmlspecialchars($user['role']) ?></div>
        </div>

        <div class="actions">
            <a href="dashboard.php" class="btn btn-back">⬅ กลับหน้าหลัก</a>
            <a href="logout.php" class="btn btn-logout">ออกจากระบบ</a>
        </div>

    </div>
</div>

<script>
// คลิกไอคอน + → เปิดเลือกไฟล์
const avatarInput = document.getElementById('avatar');
const uploadIcon = document.querySelector('.upload-icon');

uploadIcon.addEventListener('click', function(){
    avatarInput.click();
});

// ถ้าเลือกไฟล์แล้ว submit form อัตโนมัติ
avatarInput.addEventListener('change', function(){
    if(avatarInput.files.length > 0){
        document.getElementById('avatarForm').submit();
    }
});
</script>

</body>
</html>
