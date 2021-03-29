<?php
declare(strict_types=1);
namespace Serokuz\OneCApi\Services;

use Illuminate\Support\Facades\Config;
use Serokuz\OneCApi\Auth;
use Serokuz\OneCApi\Exception\ExceptionOneCApi;
use Serokuz\OneCApi\Parser\XmlCatalogParser;
use Serokuz\OneCApi\Parser\XmlOffersParser;
use Serokuz\OneCApi\Response;
use Symfony\Component\HttpFoundation\Request;

class CatalogService
{
    private $auth;

    private $fileService;

    protected $config;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->config = Config::get('one-c.setup');
    }

    /**
     * @return string
     * @throws ExceptionOneCApi
     */
    public function route() : string
    {
        $mode = $this->request->get('mode');

        switch ($mode){
            case 'checkauth':
                return $this->checkauth();
            case 'init':
                return $this->init();
            case 'file':
                return $this->file();
            case 'import':
                return $this->import();
        }

        throw new ExceptionOneCApi('OneCApi: CatalogService->route error, mode='.$mode." not supported.");
    }

    /**
     * ?type=catalog&mode=checkauth
     *
     * @return string
     * @throws ExceptionOneCApi
     */
    public function checkauth() : string
    {
        return $this->getAuth()->auth();
    }

    /**
     * ?type=catalog&mode=init
     *
     * @return string
     * @throws ExceptionOneCApi
     */
    public function init() : string
    {
        $this->getAuth()->isAuth();
        $this->getFileService()->unlinkImportDir();

        $response = new Response();
        $response
            ->set('zip', ($this->config['use_zip'] ? 'yes' : 'no'))
            ->set('file_limit', (string)$this->config['file_limit']);

        return $response->getResponse();
    }

    /**
     * ?type=catalog&mode=file
     *
     * @return string
     * @throws ExceptionOneCApi
     */
    public function file() : string
    {
        $this->getAuth()->isAuth();

        $this->getFileService()->load($this->request);

        $response = new Response();

        return $response->set('success')->getResponse();
    }

    /**
     * ?type=catalog&mode=import&filename=<имя файла>
     *
     * @return string
     * @throws ExceptionOneCApi
     */
    public function import() : string
    {
        $this->getAuth()->isAuth();

        $response = new Response();

        if($this->config['use_zip'])
            $this->getFileService()->unzipAll();

        $fileName = $this->request->get('filename');

        switch ($fileName){
            case 'import.xml':
                $catalogParser = new XmlCatalogParser();
                $catalogParser->init($fileName)->runCatalog();
                break;
            case 'offers.xml':
                $offersParse = new XmlOffersParser();
                $offersParse->init($fileName)->run();
                break;
        }

        $response->success($this->request->getSession()->getId());

        return $response->getResponse();
    }

    /**
     * @return Auth
     * @throws ExceptionOneCApi
     */
    protected function getAuth() : Auth
    {
        if($this->auth)
            return $this->auth;
        else{
            if($this->request){
                $this->auth = new Auth($this->request);
                return $this->auth;
            }
            else {
                throw new ExceptionOneCApi('OneCApi: CatalogService->getAuth error, no request.');
            }
        }
    }

    /**
     * @return FileService
     */
    protected function getFileService() : FileService
    {
        if($this->fileService)
            return $this->fileService;
        else{
            $this->fileService = new FileService();
            return $this->fileService;
        }
    }
}
