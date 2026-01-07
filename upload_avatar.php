<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if(isset($_FILES['avatar'])){
    $file = $_FILES['avatar'];
    $allowed = ['jpg','jpeg','png','gif'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        die("ไฟล์ไม่ถูกต้อง! ต้องเป็น JPG, PNG, GIF เท่านั้น");
    }

    if($file['size'] > 2*1024*1024){ // 2MB
        die("ไฟล์ใหญ่เกินไป! สูงสุด 2MB");
    }

    $newName = uniqid().".".$ext;
    $uploadDir = "uploads/"; // ต้องสร้างโฟลเดอร์ uploads
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $target = $uploadDir.$newName;
    if(move_uploaded_file($file['tmp_name'], $target)){
        // อัปเดตฐานข้อมูล
        $stmt = $conn->prepare("UPDATE users SET avatar=? WHERE username=?");
        $stmt->bind_param("ss",$target,$username);
        $stmt->execute();
        $stmt->close();

        header("Location: profile.php");
        exit();
    } else {
        die("อัปโหลดไฟล์ล้มเหลว");
    }
}
?>
