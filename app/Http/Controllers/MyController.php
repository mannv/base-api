<?php

namespace App\Http\Controllers;

use App\Providers\LoggerServiceProvider;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Route;
use Laravel\Lumen\Routing\Controller as BaseController;

class MyController extends BaseController
{
    use Helpers;
    /**
     * @var LoggerServiceProvider
     */
    protected $logger;

    public function __construct()
    {
        $this->logger = new LoggerServiceProvider();
    }

    /**
     * @param \Exception $ex
     * @param Request $request
     * @return mixed
     */
    protected function showException(\Exception $ex)
    {
        $this->logger->error('action error: ' . $ex->getMessage(), $_REQUEST);
        return $this->errorNotFound($ex->getMessage(), false);
    }

    /**
     * @param string $message
     */
    protected function errorNotFound($message = 'Not Found', $log = false)
    {
        if($log) {
            $this->logger->debug($message);
        }
        return $this->response->errorNotFound($message);
    }

    /**
     * @param string $message
     */
    protected function errorUnauthorized($message = 'Unauthorized')
    {
        $this->logger->debug($message);
        return $this->response->errorUnauthorized($message);
    }

    /**
     * @param array $arr
     */
    protected function responseArray($arr = array())
    {
        return $this->response->array($arr);
    }

    /**
     * @param $item
     * @param $transformer
     */
    protected function responseItem($item, $transformer)
    {
        return $this->response->item($item, $transformer);
    }

    /**
     * @param Collection $collection
     * @param $transformer
     */
    protected function responseCollection(Collection $collection, $transformer)
    {
        return $this->response->collection($collection, $transformer);
    }

    /**
     * @param Paginator $paginator
     * @param $transformer
     */
    protected function responsePaginator(Paginator $paginator, $transformer)
    {
        return $this->response->paginator($paginator, $transformer);
    }

}
