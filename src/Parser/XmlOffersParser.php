<?php
declare(strict_types=1);

namespace Serokuz\OneCApi\Parser;

use Serokuz\OneCApi\Exception\ExceptionOneCApi;

class XmlOffersParser extends Xml
{
    public function init(string $fileName) : XmlOffersParser
    {
        $fullPath = $this->getPath($fileName);

        $this->xml = $this->loadXml($fullPath);

        if(!$this->xml)
            throw new ExceptionOneCApi('OneCApi: Parse error: not found ' . $fullPath);

        return $this;
    }
}
