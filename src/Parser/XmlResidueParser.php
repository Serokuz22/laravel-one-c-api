<?php
declare(strict_types=1);

namespace Serokuz\OneCApi\Parser;


class XmlResidueParser
{
    use XmlModel;
    use XmlObserver;

    private $priceParser;

    public function __construct()
    {
        $this->initModel('residue');
        $this->initObserver('residue');

        $this->priceParser = new XmlPriceParser();
    }

    /**
     * @param \SimpleXMLElement $products
     * @throws \ReflectionException
     */
    public function run(\SimpleXMLElement $products) : void
    {
        foreach ($products as $product) {
            $productId = explode('#', (string)$product->{'Ид'});

            foreach ($productId as $id) {
                $item = $this->model::where($this->id, $id)->first();

                // если найден то обновляем только филлабле поля
                if ($item) {
                    $item->fill(
                        $this->setModel($product)
                    );

                    $this->runObserver('updating', $item, $product);

                    $item->update();

                    $this->runObserver('updated', $item, $product);

                    if (isset($product->{'Цены'}->{'Цена'}))
                        $this->priceParser->run($product->{'Цены'}->{'Цена'}, $id);
                }
            }
        }
    }
}
