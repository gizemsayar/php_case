<?php
// DbConnect.php dosyasını dahil et
include('../dpapi.php');

// Veritabanı bağlantısını başlat
$db = new DbConnect();
$conn = $db->getConnection();

// malzemeler tablosundan tüm malzemleri çek
$sql = "SELECT id, name , stock , price FROM products";
$stmt = $conn->query($sql);

// malzemeler dropdown menüsüne eklemek için HTML çıktısı oluştur
if ($stmt->rowCount() > 0) {
    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        echo '<label for="stock">'. $row['stock'].'</label>';
        echo '<label for="price">'. $row['price'].'</label>';
    }
} else {
    echo '<option value="">Hiç malzeme bulunamadı</option>';
}
?>
