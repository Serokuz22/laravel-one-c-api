<?php
declare(strict_types=1);
namespace Serokuz\OneCApi\Parser;

use Serokuz\OneCApi\Exception\ExceptionOneCApi;

class XmlOffersParser extends Xml
{
    private $priceTypeParser;

    private $residueParser;

    /**
     * @param string $fileName
     * @return XmlOffersParser
     * @throws ExceptionOneCApi
     */
    public function init(string $fileName) : XmlOffersParser
    {
        $fullPath = $this->getPath($fileName);

        $this->xml = $this->loadXml($fullPath);

        if(!$this->xml)
            throw new ExceptionOneCApi('OneCApi: Parse error: not found ' . $fullPath);

        $this->priceTypeParser = new XmlPriceTypeParser();
        $this->residueParser = new XmlResidueParser();

        return $this;
    }

    public function run()
    {
        $this->priceType()
            ->offer();
    }

    public function priceType() : XmlOffersParser
    {
        $this->priceTypeParser->run($this->xml->{'ПакетПредложений'}->{'ТипыЦен'}->{'ТипЦены'});
        return $this;
    }

    public function offer() : XmlOffersParser
    {
        $this->residueParser->run($this->xml->{'ПакетПредложений'}->{'Предложения'}->{'Предложение'});
        return $this;
    }
}
