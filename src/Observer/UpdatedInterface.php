<?php
namespace Serokuz\OneCApi\Observer;

use Illuminate\Database\Eloquent\Model;

interface UpdatedInterface
{
    // Событие после создания и сохраннения новой модели
    public function updated(Model $model, \SimpleXMLElement $xml) : void;
}
