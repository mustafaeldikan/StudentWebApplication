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

// استقبال البيانات من الواجهة الأمامية
$isim = $_POST['isim'];
$soyisim = $_POST['soyisim'];
$dogumYeri = $_POST['dogumYeri'];
$dogumTarihi = $_POST['dogumTarihi'];

// استعداد استعلام الإضافة
$sql = "INSERT INTO studentdb (fname, lname, birthPlace, birthDate) VALUES ('$isim', '$soyisim', '$dogumYeri', '$dogumTarihi')";

if ($conn->query($sql) === TRUE) {
    echo "Yeni kayıt başarıyla eklendi.";
} else {
    echo "Ekleme sırasında bir hata oluştu !! " . $conn->error;
}

$conn->close();
?>
