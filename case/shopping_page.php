<?php
// URL üzerinden gelen 'username' parametresini alalım
/*if (isset($_GET['username'])) {
    print($_GET['id']);
    $username = htmlspecialchars($_GET['username']); // Güvenlik için htmlspecialchars kullanıyoruz
} else {
    $username = 'Ziyaretçi'; // Eğer parametre yoksa, varsayılan bir değer belirleyebiliriz
}
*/

if (isset($_GET['username'])) {
    // URL'deki özel karakterleri çözümle
    $username = urldecode($_GET['username']);
    // 'username' parametresini ayrıştırmak için '=' karakterine göre bölelim
    // İlgili parametreyi çözümlemek için bu örnekte substr() kullanıyoruz.
    $parts = explode('id', $username);

    if (count($parts) > 1) {
        // Eğer id parametresi varsa, malzeme adı ve id'yi ayrı olarak alıyoruz
        $user = trim($parts[0]); // malzeme adını alıyoruz
        $id = trim(str_replace('=', '', $parts[1])); // id'yi alıyoruz (id=1 kısmını)
    } else {
        echo "ID bilgisi bulunamadı.<br>";
    }
} else {
    echo "Username parametresi yok.<br>";
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- jQuery Kütüphanesini dahil ediyoruz (AJAX için) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Malzeme listesi butonuna tıklandığında AJAX çağrısı yapılır
        $(document).ready(function() {
            $('#loadProductButton').click(function() {
                // AJAX isteği gönderilir
                $.ajax({
                    url: 'Products.php',  // PHP dosyasına AJAX isteği
                    type: 'GET',          // GET yöntemiyle veri gönderiyoruz
                    success: function(response) {
                        // Gelen malzeme listesine göre dropdown'ı doldur
                        $('#id').html(response);
                    }
                });
            });

            // Dropdown'dan malzeme seçildiğinde, userId'yi göndeririz
            $('#submitButton').click(function() {
                var selectedProductId = $('#id').val(); // Seçilen id'yi al
                var quantity = $('#quantity').val();
                if (selectedProductId) {

                    $.ajax({
                        url: 'processProduct.php',  // Seçilen productId'yi işleyen PHP dosyasına gönderilecek
                        type: 'POST',
                        data: {  islem:"sepete_ekle", id: selectedProductId , miktar: quantity },
                        success: function(response) {
                            // Malzeme bilgilerini ekrana yazdırır
                            $('#productInfo').html(response);
                        }
                    });
                } else {
                    alert("Lütfen bir malzeme secin.");
                }
            });
            $('#buyButton').click(function() {
                // malzemeleri al
                var productInfo = $('#productInfo').html();

                // Eğer #productinfo alanında içerik varsa
                if (productInfo.trim() !== "") {
                   
                    // İçerik varsa, onaylama işlemi
                   
                    var productInfoArray = productInfo.split(":");  // text olarak tuttugum veriyi boluyorum
                    // Veriyi daha da bölüyoruz
                    var productId = productInfoArray[1].trim();  // id:1 gibi kısmı alıyoruz
                    var quantity = productInfoArray[2].trim();  // sepete eklenen miktarı alıyoruz
                    var total = productInfoArray[3].trim();  // sepelt toplami

                    $.ajax({
                    url: 'orders.php',  // Veriyi göndereceğimiz PHP dosyası
                    type: 'POST',  // POST metodu ile veri gönderiyoruz
                    data: {
                        product_id: productId,  // Ürün ID
                        quantity: quantity,  // Sepete eklenen miktar
                        total: total  // Sepet toplamı
                    },
                    success: function(response) {
                        // Eğer işlem başarılı olursa
                        alert("siparis alindi");
                        location.reload();  // Sayfayı yenile
                    },
                    error: function(xhr, status, error) {
                        // Hata durumunda
                        console.log('Bir hata oluştu: ' + error);
                    }
                });
                }
            });

            $('#id').change(function() {
                var selectedProductId = $('#id').val(); // Seçilen id'yi al
                if (selectedProductId) {
                    $.ajax({
                        url: 'processProduct.php',  // Seçilen productId'yi işleyen PHP dosyasına gönderilecek
                        type: 'POST',
                        data: { islem:"malzeme_secimi" ,id: selectedProductId , miktar: 0 },
                        success: function(response) {
                            // Malzeme bilgilerini ekrana yazdırır
                            $('#stock').text(response);
                        }
                    });
                } else {
                    alert("Lütfen bir malzeme secin.");
                }
            });

        });
    </script>
</head>
<body>
    <div class="header" >
        <h4>Hoşgeldiniz <?php echo $user; ?></h4>
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-button">Çıkış Yap</button>
        </form>
    </div>
    <!-- Malzemeleri yükle butonu -->
    <button id="loadProductButton">Malzemeleri Yükle</button>

    <!-- Malzeme listesi dropdown -->
    <select name="id" id="id">
        <option value="0">Malzeme Seçin</option>
    </select>
    <span id="stock"></span>
    <input type="text" id="quantity" name="quantity">
    <!-- Seçilen malzemenin stok durumunu gösterme butonu -->
    <button id="submitButton">Sepete Ekle</button>

    <!-- Seçilen malzeme bilgilerini ekrana yazdir -->
     <h4>Seçilen Malzemeler</h4>
    <div id="productInfo"></div>
    <button id="buyButton" class="buy-button">Onay</button>
    
    <!-- çıkış butonu icin css yazdim-->
    <style>
         .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            color: white;
            font-size: 12px;
            border-radius: 5px;
            background-color: #fb1219;
        }
        .buy-button {
            position: fixed;
            bottom: 20px;  /* Ekranın alt kısmına 20px mesafe */
            right: 20px;   /* Ekranın sağ kısmına 20px mesafe */
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</body>
</html>
