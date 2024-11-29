<?php
session_start();  // Oturum başlatılır

// Oturumu sonlandır
session_unset();
session_destroy();

// Çıkış yapıldığında giriş sayfasına yönlendir
header('Location: login.html');
exit();
?>