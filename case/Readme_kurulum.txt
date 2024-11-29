1) mysql kurulumu yapılması gerekmektedir.
https://dev.mysql.com/downloads/workbench/ sçtesinden bilgisayarınız özelliklerine uygun olan sürümü indirin.
2) php kurulumu yapılması gerekmektedir.,
https://www.php.net/downloads.php sitesinden 8.4.1 indiriniz.
uygulama C içerisine taşınmalı
sistem değişkenlerinden path içerisine ekle
3) wamp server kurulumu yapınız 
https://sourceforge.net/projects/wampserver/ son sürümü indiriniz.

php kod hatası alınırsa kontrol edilmeli;
gerekli kurulumlar sağlandıktan sonra wamp server çalıştırılmalı(yeşil olduğunda çalışıyor demek)
Eğer php kodları doğru çalışmıyorsa wamp server içerisindeki PHP.İNİ dosyasını açı extension ayarlarınızı kontrol ediniz.
;extension ifadesi olanları extension bu hale çevirdiğinizde düzelecektir izinler tamamlanacaktır.

mysql import işlemi;
Gönderilen backup dosyası -> Administration->Data iport kısmından bilgisayarınıza indirdiğiniz yerden çekiniz.
Veri tabanı yüklenecektir.