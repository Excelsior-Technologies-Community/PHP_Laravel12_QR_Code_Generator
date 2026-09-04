<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'qr_code',
        'qr_foreground_color',
        'qr_background_color',
        'qr_size',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'qr_size' => 'integer',
    ];

    public function qrScans(): HasMany
    {
        return $this->hasMany(QrScan::class);
    }
}