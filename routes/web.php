<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Basic QR Code
|--------------------------------------------------------------------------
*/

Route::get('qrcodes', function () {
    return QrCode::size(300)
        ->generate('A basic example of QR code!');
});

/*
|--------------------------------------------------------------------------
| QR Code Save
|--------------------------------------------------------------------------
*/

Route::get('qrcode-save', function () {

    $directory = public_path('qrcode');

    if (!is_dir($directory)) {
        mkdir($directory, 0755, true);
    }

    $path = $directory . '/' . time() . '.png';

    return QrCode::size(300)
        ->generate(
            'A simple example of QR code',
            $path
        );
});

/*
|--------------------------------------------------------------------------
| QR Code With Color
|--------------------------------------------------------------------------
*/

Route::get('qrcode-with-color', function () {

    return QrCode::size(300)
        ->backgroundColor(255, 55, 0)
        ->generate(
            'A simple example of QR code with background color'
        );
});

/*
|--------------------------------------------------------------------------
| Email QR Code
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
| Phone QR Code
|--------------------------------------------------------------------------
*/

Route::get('qr-phone', function () {

    return QrCode::size(300)
        ->phoneNumber('111-222-6666');
});

/*
|--------------------------------------------------------------------------
| SMS QR Code
|--------------------------------------------------------------------------
*/

Route::get('qr-sms', function () {

    return QrCode::size(300)
        ->SMS(
            '111-222-6666',
            'Body of the message'
        );
});

/*
|--------------------------------------------------------------------------
| Product QR Routes
|--------------------------------------------------------------------------
*/

/*
 * Dedicated QR tracking URL.
 *
 * QR Code → this route → record scan → product page.
 */
Route::get(
    'products/{product}/qr',
    [ProductController::class, 'qrRedirect']
)->name('products.qr.redirect');

/*
|--------------------------------------------------------------------------
| Product Resource Routes
|--------------------------------------------------------------------------
*/

Route::resource('products', ProductController::class)
    ->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ]);

/*
|--------------------------------------------------------------------------
| Regenerate QR
|--------------------------------------------------------------------------
*/

Route::post(
    'products/{product}/regenerate-qr',
    [ProductController::class, 'regenerateQr']
)->name('products.regenerate-qr');