
  

Kullanılan ekstra kütüphaneler

- https://github.com/PHLAK/SemVer

  

---

  

Kurulum için tetiklenmesi gerekli olan komutlar aşağıda belirtilmiştir.

> docker-compose -f "docker-compose.yml" up -d --build

> docker-compose exec php php artisan migrate

  
  

Dummy Data doldurmak için aşağıdaki komutu tetikleyiniz

> docker-compose exec php php artisan db:seed

  

---

  

MySQL Kullanıcı bilgileri

|Açıklama|Değer|
|--|--|
| Veritabanı adı|challenge |
|Kullanıcı adı|root|
|Parola|root|

 

---

  

API için Endpointler aşağıda tarafınıza sunulmuştur.

| Method | Endpoint | Açıklama
|--|--|--|
|GET|api/v1| Sürüm kontrolü, token oluşturma ve güncelleme kontrolü |
|GET|api/v1/categories| Kategorileri getirir |
|GET|api/v1/categories/{id}| ID'si verilen kategorideki Medyaları getirir |
|GET|api/v1/favorites| Kullanıcının Favorilerini getirir |
|POST|api/v1/favorites| Gönderilen Form-Data[media_id] favorilere ekler. |
|DELETE|api/v1/favorites/{id}| {id} değerine sahip olan veriyi favorilerden kaldırır |
|GET|api/v1/media/{id}| {id} değerine sahip olan medyayı, bağlı olduğu kategoriyi ve favori bilgisini getirir |
