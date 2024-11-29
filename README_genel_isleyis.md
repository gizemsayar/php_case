uygulama case dosyası içerisinde yer alan login.html sayfası ile başlamaktadır.
url : http://localhost/case/login.html

 giriş kısmında login ve dpapi ve conf_inc sayfaları özellikle oluşturdum.
dpapi ile veritabanı baglantısı yapıyorum burada veritabanı isimleri dommek istemedim conf_inc sayfasına yazdım 
ileride birden fazla veritabanı olması durumunda ssadece buradan ekleme yaıp gerekli cagırma islemlerinin cagrılması
yeterli olacaktır.

-- içeride 2 tip kullanıcı vardır admin ve normal kullanıcı.
admin kullanıcıadı: gizemzebek sifre:Gizem1234
normal kullanıcı : gizem sifre:deneme1
--Bu bilgileri veritabanında users isimli tablodan çekmektedir. şifre yanlış girilirse sisteme giriş yapmaz.
--normal kullanıcı urun silme islemi urun bilgisi update gibi islemler yapamaz.

login islemi basarili olursa shopping.php sayfasina gidecektir.
burada iceride mevcut olan ürünleri gorebilir ve sepete ekleyebilir ekleme ve onaylama adımına giderken veritabanından
stok kontrolü sağlanmaktadır.


stok kontrolü orders tablosundaki satın alinan miktar toplamı - products tablosundaki 
stoktan düzmektedir her siparis sonrasi yenilenmektedir.

veri tabanına indexler eklenmistir,sorgulamalarda yavaslama olmamasi icin.
