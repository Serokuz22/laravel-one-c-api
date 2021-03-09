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

    /**
     * События и интерфейсы
     * @var array
     */
    private $events = [
        'created'  => CreatedInterface::class,
        'creating' => CreatingInterface::class,
        'updated'  => UpdatedInterface::class,
        'updating' => UpdatingInterface::class
    ];

    /**
     * @param string $model
     * @throws \ReflectionException
     */
    private function initObserver(string $model) : void
    {
        $this->observer = null;
        $observer = config('one-c.models.'.$model.'.observer');

        if($observer) {
            $reflectionClass = new \ReflectionClass($observer);

            if (!$reflectionClass->isInstantiable()) {
                \Log::debug('OneCApi: Observer=' . $observer . ' not used.');
                $this->observer = null;
            } else {
                $this->observer = new $observer();
            }
        }
    }

    /**
     * @param string $event
     * @return string|null
     */
    private function observerGetInterface(string $event) : ?string
    {
        if(isset($this->events[$event])){
            return $this->events[$event];
        }

        return null;
    }

    /**
     * Попробовать выполнить событие
     *
     * @param string $event
     * @param Model $model
     * @param \SimpleXMLElement $xml
     */
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
