#  PHP_Laravel12_QR_Code_Generator 

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-f72c1f?style=for-the-badge&logo=laravel" />
  <img src="https://img.shields.io/badge/PHP-8.2-blue?style=for-the-badge&logo=php" />
  <img src="https://img.shields.io/badge/QR--Code-Generator-green?style=for-the-badge" />
</p>

---

##  Overview  
This project demonstrates how to generate **QR Codes** in Laravel using the package:  
 simplesoftwareio/simple-qrcode

You will learn:
- Basic QR Code  
- Save QR Code to Image  
- Colored QR Code  
- Email QR Code  
- Phone Number QR Code  
- SMS QR Code  

---

##  Features  
- Text QR Code  
- Save QR Code as PNG  
- Background color QR  
- Email QR Code  
- Phone Number QR Code  
- SMS QR Code  
- Clean routes for each QR example  

---

##  Folder Structure  
```
routes/
└── web.php

public/
└── qrcode/           

composer.json
.env
README.md
```

---

#  Step 1 — Install Laravel  
```bash
composer create-project laravel/laravel qr-project
cd qr-project
php artisan serve
```

---

#  Step 2 — Database Configuration (Optional)

 .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

---

#  Step 3 — Install QR Code Package  
```bash
composer require simplesoftwareio/simple-qrcode
```

---

#  Step 4 — Import QR Facade  
```php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
```

---

#  Step 5 — Add QR Code Routes  

##  1. Basic QR Code  
```php
Route::get('qrcodes', function () {
    return QrCode::size(300)->generate('A basic example of QR code!');
});
```
<img width="383" height="393" alt="Screenshot 2025-12-08 180056" src="https://github.com/user-attachments/assets/38d75e4a-657c-42ad-8452-c06f9bd944a9" />

---

##  2. QR Code (Save to File)  
 Create folder first: **public/qrcode/**

```php
Route::get('qrcode-save', function () {
    $path = public_path('qrcode/' . time() . '.png');
    return QrCode::size(300)->generate('A simple example of QR code', $path);
});
```

---

##  3. QR Code With Background Color  

```php
Route::get('qrcode-with-color', function () {
    return QrCode::size(300)
                 ->backgroundColor(255, 55, 0)
                 ->generate('A simple example of QR code with background color');
});
```
<img width="419" height="366" alt="Screenshot 2025-12-08 175755" src="https://github.com/user-attachments/assets/e14b5f9e-19b6-48e2-8d07-516f975f15ef" />

---

##  4. Email QR Code  

```php
Route::get('qrcode-email', function () {
    return QrCode::size(500)
        ->email('hardik@itsolutionstuff.com', 'Welcome to ItSolutionStuff.com!', 'This is !.');
});
```
<img width="564" height="582" alt="Screenshot 2025-12-08 175947" src="https://github.com/user-attachments/assets/4076dbc5-ac2e-4f6f-a821-0e0aab291682" />

---

##  5. Phone Number QR Code  

```php
Route::get('qr-phone', function () {
    return QrCode::size(300)->phoneNumber('111-222-6666');
});
```
<img width="382" height="393" alt="Screenshot 2025-12-08 180014" src="https://github.com/user-attachments/assets/77f0d2ff-18b8-4b0d-833b-8be0c817272b" />

---

##  6. SMS QR Code  

```php
Route::get('qr-sms', function () {
    return QrCode::size(300)->SMS('111-222-6666', 'Body of the message');
});
```
<img width="380" height="410" alt="Screenshot 2025-12-08 180028" src="https://github.com/user-attachments/assets/2ab701a6-5867-4d19-9119-819249e3fba3" />

---

#  Clear Cache  

```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
php artisan serve
```

---

#  Your Laravel QR System is Ready  

You now have all types of QR codes working:
✔ Basic  
✔ Save to image  
✔ Colored  
✔ Email  
✔ Phone  
✔ SMS  

---


