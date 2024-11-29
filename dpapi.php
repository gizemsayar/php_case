<?php
// yapilandirma dosyasini dahil et
include('conf_inc.php');

class DbConnect {
    private $conn;

    public function __construct() {
        // baglantiyi olusturma
        $this->connect();
    }

    // veritabani baglantisi kurma fonksiyonu
    private function connect() {
        try {
            // PDO ile MySQL'e baglanma
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            
            // Hata ayiklama modu
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Bağlantı hatası: " . $e->getMessage());
        }
    }
    

    // veritabani baglantisini donduren fonksiyon
    public function getConnection() {
        return $this->conn;
    }
}
?>
