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
        ->generate(
            'A basic example of QR code!'
        );
});


/*
|--------------------------------------------------------------------------
| QR Code Save
|--------------------------------------------------------------------------
*/

Route::get('qrcode-save', function () {

    $directory = public_path('qrcode');

    if (!is_dir($directory)) {
        mkdir(
            $directory,
            0755,
            true
        );
    }

    $path =
        $directory .
        '/' .
        time() .
        '.png';

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

Route::get(
    'qrcode-with-color',
    function () {

        return QrCode::size(300)
            ->backgroundColor(
                255,
                55,
                0
            )
            ->generate(
                'A simple example of QR code with background color'
            );
    }
);


/*
|--------------------------------------------------------------------------
| Email QR
|--------------------------------------------------------------------------
*/

Route::get(
    'qrcode-email',
    function () {

        return QrCode::size(500)
            ->email(
                'hardik@itsolutionstuff.com',
                'Welcome to ItSolutionStuff.com!',
                'This is !.'
            );
    }
);


/*
|--------------------------------------------------------------------------
| Phone QR
|--------------------------------------------------------------------------
*/

Route::get(
    'qr-phone',
    function () {

        return QrCode::size(300)
            ->phoneNumber(
                '111-222-6666'
            );
    }
);


/*
|--------------------------------------------------------------------------
| SMS QR
|--------------------------------------------------------------------------
*/

Route::get(
    'qr-sms',
    function () {

        return QrCode::size(300)
            ->SMS(
                '111-222-6666',
                'Body of the message'
            );
    }
);


/*
|--------------------------------------------------------------------------
| PRODUCT QR TRACKING
|--------------------------------------------------------------------------
|
| QR Code
|     ↓
| Tracking URL
|     ↓
| Record Scan
|     ↓
| Product Page
|
*/

Route::get(
    'products/{product}/qr',
    [
        ProductController::class,
        'qrRedirect'
    ]
)->name(
    'products.qr.redirect'
);


/*
|--------------------------------------------------------------------------
| PRODUCT ANALYTICS
|--------------------------------------------------------------------------
*/

Route::get(
    'products-analytics',
    [
        ProductController::class,
        'analytics'
    ]
)->name(
    'products.analytics'
);


/*
|--------------------------------------------------------------------------
| PRODUCT QR DOWNLOAD
|--------------------------------------------------------------------------
*/

Route::get(
    'products/{product}/download-qr',
    [
        ProductController::class,
        'downloadQr'
    ]
)->name(
    'products.download-qr'
);


/*
|--------------------------------------------------------------------------
| PRODUCT QR CSV EXPORT
|--------------------------------------------------------------------------
*/

Route::get(
    'products/{product}/export-scans',
    [
        ProductController::class,
        'exportScans'
    ]
)->name(
    'products.export-scans'
);


/*
|--------------------------------------------------------------------------
| PRODUCT STATUS
|--------------------------------------------------------------------------
*/

Route::post(
    'products/{product}/toggle-status',
    [
        ProductController::class,
        'toggleStatus'
    ]
)->name(
    'products.toggle-status'
);


/*
|--------------------------------------------------------------------------
| PRODUCT RESOURCE
|--------------------------------------------------------------------------
*/

Route::resource(
    'products',
    ProductController::class
)->only([
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
| REGENERATE QR
|--------------------------------------------------------------------------
*/

Route::post(
    'products/{product}/regenerate-qr',
    [
        ProductController::class,
        'regenerateQr'
    ]
)->name(
    'products.regenerate-qr'
);
