<?php
session_start();  // Oturum başlatılır

include('../dpapi.php');  // Bu dosya, veritabanı bağlantısını yapar

// Veritabanı bağlantısını başlat
$db = new DbConnect();
$conn = $db->getConnection();  // Bağlantıyı al

// AJAX ile gönderilen verileri al
$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$total = $_POST['total'];


$zaman=date('Y-m-d H:i:s');
// SQL sorgusunu hazırla
$sql = "INSERT INTO orders (user_id,product_id,purchase_quantity,total_amount , status,created_at) VALUES (1,:product_id, :quantity,:total ,1, :created_at)";
try {
    // Prepared statement ile sorguyu hazırlıyoruz
    $stmt = $conn->prepare($sql);

    // Parametreleri bağla
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);   
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT); 
    $stmt->bindParam(':total', $total, PDO::PARAM_INT); 
  //  $stmt->bindParam(':status', $quantity, PDO::PARAM_INT);  // 'quantity' burada status olarak kabul ediliyor, bir hata varsa düzeltin
    $stmt->bindParam(':created_at', $zaman, PDO::PARAM_STR); 

    // Sorguyu çalıştır
    $stmt->execute();
    echo "Ürün başarıyla eklendi!";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
// Bağlantıyı kapat
//$conn->close();
$conn = null;  // PDO bağlantısını null yaparak kapatıyoruz

?>
