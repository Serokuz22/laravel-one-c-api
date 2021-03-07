Laravel OneCApi
=============

Данный пакет автоматизирует загрузку прайса из 1С через стандартный интерфейс обмена данных.

Я реализую прямую загрузку в бд через модели.

на данном этапе это dev вариант и загружается только группы и каталог, буду признателен если ктото решит потестировать.

#Установка
````
composer require serokuz/laravel-one-c-api --dev
````

#Публикуем config/one-c.php
```
php artisan vendor:publish --provider "Serokuz\OneCApi\OneCApiServiceProvider" --tag="config"
```

#Observer
Интерфейс позволяет выполнять свой код до записи в бд и после.

В конфигурации значение для модели 'observer' => <Класс>

Достоупны 4 интерфейса:

     CreatedInterface - Событие после создания и сохраннения новой модели
     CreatingInterface - Событие до создания и сохраннения новой модели
     UpdatedInterface - Событие после сохраннения уже найденной модели
     UpdatingInterface - Событие до сохраннения уже найденной модели

Нужно реализовать эти интерфейсы в классе, все либо выборочно.

Параметры функции: 

Model $model  - модель с уже автоматически заполненными данными 
SimpleXMLElement $xml = сырые данные которы вы можете использовать

Тем самым вы можете реализовать свои специфические обработки данных

Пример:
````
class TestOneCApiObserver implements UpdatedInterface, UpdatingInterface
{

    public function updated(Model $model, \SimpleXMLElement $xml): void
    {
        \Log::debug('Updated');
    }

    public function updating(Model $model, \SimpleXMLElement $xml): void
    {
        $model->name .=' Test Test';
    }
}
````
