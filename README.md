## Task Test Edilmesi

Aşağıdaki komutların sırasıyla çalıştırılması gerekmektedir.

    docker-compose up -d
    docker exec -it case sh
    cp .env.example .env
    composer install
    php artisan migrate --seed

Postman dokümantasyonundan endpointleri direkt çalıştırabilirsiniz.

### Doküman Linki

<a> https://documenter.getpostman.com/view/13527177/2sAYBSmDoh </a>

Yukarıdaki komutlar çalıştırdıktan sonra aşağıdaki endpointleriden test işlemleri gerçekleştirilebilir.

### Orders - Sipariş işlemleri

#### Sipariş oluşturma
    
    POST http://localhost:8001/api/orders

#### Siparişleri çekme

    GET http://localhost:8001/api/orders

#### Sipariş Silme

    DELETE http://localhost:8001/api/orders/:orderId

### Product - Ürün işlemleri

#### Ürün ekleme, silme veya güncelleme ile ilgili herhangi bir endpoint oluşturmadım. Sadece ürünleri çekecek endpointi oluşturdum.

    GET http://localhost:8001/api/products

### Campaign - Kampanya işlemleri

#### Oluşturulan kampanya verileri çekmek için aşağıdaki endpoint kullanılabillir.

    GET http://localhost:8001/api/campaigns

#### Yeni bir kampanya oluşturmak için

    POST http://localhost:8001/api/campaigns

#### Oluşturulan bir siparişe indirimleri hesaplatmak için aşağıdaki endpointi oluşturdum.

    PATCH http://localhost:8001/api/campaigns/apply/:orderId
