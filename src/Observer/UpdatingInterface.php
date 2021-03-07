<?php
namespace Serokuz\OneCApi\Observer;


use Illuminate\Database\Eloquent\Model;

interface UpdatingInterface
{
    // Событие до сохранения в бд данных
    public function updating(Model $model, \SimpleXMLElement $xml) : void;
}
