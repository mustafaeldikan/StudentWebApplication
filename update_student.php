<?php
// تحديد معلومات الاتصال بقاعدة البيانات
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

// استقبال البيانات من الجانب الأمامي
$sid = $_POST['sid'];
$isim = $_POST['isim'];
$soyisim = $_POST['soyisim'];
$dogumYeri = $_POST['dogumYeri'];
$dogumTarihi = $_POST['dogumTarihi'];

// استعداد استعلام التحديث
$sql = "UPDATE studentdb SET fname='$isim', lname='$soyisim', birthPlace='$dogumYeri', birthDate='$dogumTarihi' WHERE sid=$sid";

if ($conn->query($sql) === TRUE) {
    echo "Kayıt başarıyla güncellendi.";
} else {
    echo "Güncelleme sırasında bir hata oluştu !! " . $conn->error;
}

$conn->close();
?>
