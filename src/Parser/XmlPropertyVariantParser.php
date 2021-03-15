<?php
declare(strict_types=1);

namespace Serokuz\OneCApi\Parser;


class XmlPropertyVariantParser
{
    use XmlModel;

    public function __construct()
    {
        $this->initModel('property_variants');
    }

    /**
     * @param \SimpleXMLElement $variants
     * @param string $propertyId
     * @throws \ReflectionException
     */
    public function run(\SimpleXMLElement $variants, string $propertyId) : void
    {
        // если класс не определен то не парсим просто выходим без ошибок
        if(!$this->isInstantiable()) {
            \Log::debug('OneCApi: property_variant='.$this->model.' not used.');
            return;
        }

        // Удаляем старые
        $this->model::where($this->id, $propertyId)->delete();

        foreach ($variants as $variant) {
            $item = new $this->model();
            $item->setAttribute($this->id, $propertyId);
            $item->fill(
                $this->setModel($variant)
            );
            $item->save();
        }
    }
}
