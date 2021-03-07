<?php
namespace Serokuz\OneCApi\Parser;


use Illuminate\Database\Eloquent\Model;
use Serokuz\OneCApi\Observer\CreatedInterface;
use Serokuz\OneCApi\Observer\CreatingInterface;
use Serokuz\OneCApi\Observer\UpdatedInterface;
use Serokuz\OneCApi\Observer\UpdatingInterface;

trait XmlObserver
{
    private $observer;

    private $events = [
        'created'  => CreatedInterface::class,
        'creating' => CreatingInterface::class,
        'updated'  => UpdatedInterface::class,
        'updating' => UpdatingInterface::class
    ];

    private function initObserver(string $model) : void
    {
        $observer = config('one-c.models.'.$model.'.observer');

        $reflectionClass = new \ReflectionClass($observer);

        if(!$reflectionClass->isInstantiable()) {
            \Log::debug('OneCApi: attribute_values='.$observer.' not used.');
            $this->observer = null;
        }
        else{
            $this->observer = new $observer;
        }
    }

    private function observerGetInterface(string $event) : ?string
    {
        if(isset($this->events[$event])){
            return $this->events[$event];
        }

        return null;
    }

    private function runObserver(string $event, Model $model, \SimpleXMLElement $xml)
    {
        $eventInterface = $this->observerGetInterface($event);
        if($this->observer && $eventInterface){
            if($this->observer instanceof $eventInterface){
                $this->observer->$event($model, $xml);
            }
        }
    }
}
