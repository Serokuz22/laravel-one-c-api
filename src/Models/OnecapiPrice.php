<?php
namespace Serokuz\OneCApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnecapiPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_sku',
        'view',
        'price_per_unit',
        'currency',
        'unit',
        'ratio'
    ];
}
