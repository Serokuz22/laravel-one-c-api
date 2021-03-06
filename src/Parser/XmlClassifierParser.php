<?php
declare(strict_types=1);
namespace Serokuz\OneCApi\Parser;

use Serokuz\OneCApi\Exception\ExceptionOneCApi;

class XmlClassifierParser extends Xml
{
    public function __construct(\SimpleXMLElement $classifier = null)
    {
        $this->init($classifier);
    }

    public function init(\SimpleXMLElement $classifier = null) : void
    {
        if($classifier){
            $this->xml = $classifier;
        }
        else{
            $fullPath = $this->getPath('classifier.xml');
            $this->xml = $this->loadXml($fullPath);
            if(!$this->xml)
                throw new ExceptionOneCApi('OneCApi: Parse error: not found ' . $fullPath);
        }
    }

    public function groups()
    {
        if(isset($this->xml->{'Группы'}->{'Группа'})){
            $groupParser = new XmlGroupParser();
            $groupParser->run($this->xml->{'Группы'}->{'Группа'});
        }
        else
            throw new ExceptionOneCApi('OneCApi: Parse error: group not found.');
    }

}
