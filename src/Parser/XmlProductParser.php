<?php
declare(strict_types=1);
namespace Serokuz\OneCApi\Parser;

class XmlProductParser
{
    use XmlModel;

    public function __construct()
    {
        $this->initModel('product');
    }

    /**
     * @param \SimpleXMLElement $products
     */
    public function run(\SimpleXMLElement $products) : void
    {
        foreach ($products as $product) {
            $item = $this->model::where($this->id, $product->{'Ид'})->first();

            // если найден то обновляем только филлабле поля
            if ($item) {
                $item->fill(
                    $this->setModel($product)
                );
                $item->setAttribute($this->pId, (string)$product->{'Группы'}->{'Ид'});
                $item->update();
            } else { // если нет, создаем новую запись
                $item = new $this->model;
                $item->setAttribute($this->id, (string)$product->{'Ид'});
                $item->setAttribute($this->pId, (string)$product->{'Группы'}->{'Ид'});
                $item->fill(
                    $this->setModel($product)
                );
                $item->save();
            }
        }
    }
}
