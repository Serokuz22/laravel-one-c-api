<?php
namespace Serokuz\OneCApi\Controllers;

use Illuminate\Routing\Controller;
use Serokuz\OneCApi\Exception\ExceptionOneCApi;
use Serokuz\OneCApi\Response;
use Serokuz\OneCApi\Services\CatalogService;
use Illuminate\Http\Request;

class OneCApiController extends Controller
{
    private $catalogService;


    public function index(Request $request)
    {
        $type = $request->get('type');

        try {
            if ($type == 'catalog') {
                $result = $this->runCatalogService($request);
                \Log::debug('OneCApi: $response='."\n".$result);
                return response($result, 200, ['Content-Type', 'text/plain']);
            }
            else
                throw new ExceptionOneCApi('OneCApi: type='.$type." not supported.");
        }
        catch (ExceptionOneCApi $e)
        {
            \Log::error("OneCApi: failure \n".$e->getMessage()."\n".$e->getFile()."\n".$e->getLine()."\n");

            $response = new Response();

            $response->failure()
                ->set($e->getMessage())
                ->set($e->getFile())
                ->set($e->getLine());

            return response($response->getResponse(), 500, ['Content-Type', 'text/plain']);
        }
    }

    private function runCatalogService(Request $request)
    {
        if(!$this->catalogService)
            $this->catalogService = new CatalogService($request);

        return $this->catalogService->route();
    }
}
