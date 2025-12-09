<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*
|--------------------------------------------------------------------------
| QR Code Routes
|--------------------------------------------------------------------------
| These routes demonstrate how to generate various types of QR codes using
| the simplesoftwareio/simple-qrcode package. Each route returns a QR code
| with a specific function such as simple text, color, email, phone call, etc.
*/

/*
|--------------------------------------------------------------------------
| 1. Basic QR Code
| This route generates a simple QR code containing plain text.
|--------------------------------------------------------------------------
*/
Route::get('qrcodes', function () {
    return QrCode::size(300)->generate('A basic example of QR code!');
});

/*
|--------------------------------------------------------------------------
| 2. QR Code (Save to File)
| This generates a QR code and saves it as a PNG file inside /public/qrcode/.
|--------------------------------------------------------------------------
*/
Route::get('qrcode-save', function () {
    $path = public_path('qrcode/' . time() . '.png');
    return QrCode::size(300)->generate('A simple example of QR code', $path);
});

/*
|--------------------------------------------------------------------------
| 3. QR Code With Background Color
| This QR code has a custom background color using RGB values.
|--------------------------------------------------------------------------
*/
Route::get('qrcode-with-color', function () {
    return QrCode::size(300)
                 ->backgroundColor(255, 55, 0)
                 ->generate('A simple example of QR code with background color');
});

/*
|--------------------------------------------------------------------------
| 4. Email QR Code
| Scanning this QR code opens the user's email app with:
| - Recipient email address
| - Subject
| - Pre-filled message
|--------------------------------------------------------------------------
*/
Route::get('qrcode-email', function () {
    return QrCode::size(500)
        ->email(
            'hardik@itsolutionstuff.com',
            'Welcome to ItSolutionStuff.com!',
            'This is !.'
        );
});

/*
|--------------------------------------------------------------------------
| 5. Phone Number QR Code
| Scanning this QR code opens the dialer with the phone number pre-filled.
|--------------------------------------------------------------------------
*/
Route::get('qr-phone', function () {
    return QrCode::size(300)->phoneNumber('111-222-6666');
});

/*
|--------------------------------------------------------------------------
| 6. SMS QR Code
| Scanning this QR code opens the SMS app with:
| - Phone number pre-filled
| - Message body pre-filled
|--------------------------------------------------------------------------
*/
Route::get('qr-sms', function () {
    return QrCode::size(300)->SMS('111-222-6666', 'Body of the message');
});
