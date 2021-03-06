<?php
declare(strict_types=1);
namespace Serokuz\OneCApi\Services;

use Illuminate\Support\Facades\Config;
use Serokuz\OneCApi\Exception\ExceptionOneCApi;
use Symfony\Component\HttpFoundation\Request;

class FileService
{
    protected $config;

    public function __construct()
    {
        $this->config = Config::get('one-c.setup');
    }

    /**
     * Очистить каталог от старых файлов
     */
    public function unlinkImportDir() : void
    {
        $tmpFiles = glob($this->config['import_dir'].DIRECTORY_SEPARATOR.'*.*');
        if (is_array($tmpFiles)) {
            foreach ($tmpFiles as $file) {
                unlink($file);
            }
        }
    }

    /**
     * Загружаем файла
     * @param Request $request
     * @return void
     * @throws ExceptionOneCApi
     */
    public function load(Request $request) : void
    {
        $fullPath = $this->config['import_dir'] . DIRECTORY_SEPARATOR . $request->get('filename');

        $this->checkDir($fullPath);

        $f = fopen($fullPath, 'a+');
        fwrite($f, $request->getContent());
        fclose($f);
    }

    /**
     * Распаковываем все файлы
     */
    public function unzipAll() : void
    {
        $files = glob( $this->config['import_dir'].DIRECTORY_SEPARATOR.'*.zip');
        if(is_array($files)){
            foreach ($files as $file){
                $this->unzip($file);
            }
        }
    }

    /**
     * Проверяем директорию на существования, если нет пробуем создать
     * @param string $path
     * @throws ExceptionOneCApi
     */
    private function checkDir(string $path) : void
    {
        $directory = dirname($path);

        if (!is_dir($directory)) {
            if(!mkdir($directory, 0755, true)){
                throw new ExceptionOneCApi('OneCApi: FileService mkdir = false');
            }
        }
    }

    /**
     * Распаковать архив
     * @param string $file
     */
    private function unzip(string $file)
    {
        $zip = new \ZipArchive();
        $zip->open($file);
        $zip->extractTo($this->config['import_dir']);
        $zip->close();
        unlink($file);
    }
}
