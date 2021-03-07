<?php
declare(strict_types=1);

namespace Serokuz\OneCApi\Parser;


class XmlAttributeValuesParse
{
    use XmlModel;

    public function __construct()
    {
        $this->initModel('attribute_values');
    }

    public function run(\SimpleXMLElement $attributes, string $productId) : void
    {
        $reflectionClass = new \ReflectionClass($this->model);

        // если класс не определен то не парсим просто выходим без ошибок
        if(!$reflectionClass->isInstantiable()) {
            \Log::debug('OneCApi: attribute_values='.$this->model.' not used.');
            return;
        }

        // Удаляем старые
        $this->model::where($this->id, $productId)->delete();

        foreach ($attributes as $attribute) {
            $item = new $this->model;
            $item->setAttribute($this->id, $productId);
            $item->fill(
                $this->setModel($attribute)
            );
            $item->save();
        }
    }
}
