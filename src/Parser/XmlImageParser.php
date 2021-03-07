<?php
declare(strict_types=1);

namespace Serokuz\OneCApi\Parser;

use Illuminate\Database\Eloquent\Model;

class XmlImageParser implements XmlImageParserInterface
{
    public function run(array $images, Model $model): void
    {
        \Log::debug('Add Images Model=' . $model->id . '\n'.$images);
    }
}
