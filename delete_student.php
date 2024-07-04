<?php
$servername = "localhost";
$username = "mustafa";
$password = "1234";
$dbname = "sdb";

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استقبال معرف السجل لحذفه
$sid = $_POST['sid'];

// استعلام لحذف السجل
$sql = "DELETE FROM studentdb WHERE sid = $sid";

if ($conn->query($sql) === TRUE) {
    echo "Kayıt başarıyla silindi.";
} else {
    echo "Silme sırasında bir hata oluştu !! " . $conn->error;
}

$conn->close();
?>

