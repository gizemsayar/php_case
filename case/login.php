<?php
session_start();  // Oturum başlatılır

include('../dpapi.php'); // Veritabanı bağlantısı

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kullanıcıdan gelen veriler
    $user_id ="";
    $username = $_POST['username'];
    $password = $_POST['password'];
  

    // Veritabanına bağlantı
    $db = new DbConnect();
    $conn = $db->getConnection();

    // Kullanıcıyı veritabanında kontrol et
    $sql = "SELECT id, username, password , user_type FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    // Kullanıcı bulunursa
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $user_id = $user['id']; // user_id yi gonderiyorum kontrol icin lazim
        // Şifreyi kontrol et (password_verify ile hashli şifreyi karşılaştır)
        if (password_verify($password, $user['password'])) {
            // Doğru şifre, oturum başlat
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            // Kullanıcıyı malzeme listesi sayfasına yönlendir
           // header('Location:deneme.php');
            header('Location:shopping_page.php?username=' . $username . ' id ='.$user_id.' ');
            
           // exit(); // Yönlendirme sonrası kodun devam etmesini engeller
        } else {
            // Yanlış şifre
            echo "Geçersiz şifre.";
        }
    } else {
        echo "Kullanıcı bulunamadı.";
    }
}

?>
