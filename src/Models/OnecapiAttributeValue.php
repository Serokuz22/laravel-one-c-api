<?php
namespace Serokuz\OneCApi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnecapiAttributeValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'value'
    ];
}
