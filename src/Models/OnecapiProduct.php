<?php

namespace Serokuz\OneCApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnecapiProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'art',
        'barcode',
        'residue'
    ];

    public function attribute_value()
    {
        return $this->hasMany('\Serokuz\OneCApi\Models\OnecapiAttributeValue', 'sku', 'sku');
    }
}
