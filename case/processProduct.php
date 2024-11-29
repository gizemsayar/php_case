<?php
// DbConnect.php dosyasını dahil et
include('../dpapi.php');

// Veritabanı bağlantısını başlat
$db = new DbConnect();
$conn = $db->getConnection();

// POST ile gelen productId parametresini al
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $islem=$_POST['islem'];
    $productId = $_POST['id'];  // Formdan gelen productId
    $quantity = $_POST['miktar'];

    // Veritabanından seçilen productId'yi çekmek için sorgu
    //$sql = "SELECT id, stock ,name,price FROM products WHERE id = :productId";
    $sql = "SELECT id, (stock - IFNULL((select sum(purchase_quantity)toplam_verilen_siparis 
                        from orders where product_id = :productId ),0)) stock,name,price 
            FROM products WHERE id = :productId";
    try {
        // Prepared statement ile sorguyu hazırlıyoruz
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->execute();


        // malzeme ekrana yazdırma
        if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if($islem=="malzeme_secimi")
            {
                echo "stok mik:" .$product['stock'] ;
            }
            else
            {
                if($product['stock']<$quantity)
                {
                    echo "Girdiginiz deger stok miktarından fazla";
                }
                    else{
                        $price = $product['price'];
                        $quantity = $quantity;
                        $total = $price * $quantity;
                    echo   "id: " ."$product[id]". " Sepetinize: " . $quantity ." adet "  .$product['name'] ." eklenmistir. "."Toplam Fiyat:" ."$total" . "<br>";
                    }   
                } 
            }
         
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "product ID parametresi eksik.";
}
?>
