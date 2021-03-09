<?php

namespace Serokuz\OneCApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnecapiProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function variants()
    {
        return $this->hasMany('\Serokuz\OneCApi\Models\OnecapiPropertyVariant', 'property_sku', 'sku');
    }
}
