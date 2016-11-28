<?php

namespace App\Http\Controllers;

use App\Providers\LoggerServiceProvider;
use Dingo\Api\Http\Request;
use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
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
     * @param bool $log
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
     * @return mixed
     */
    protected function responseArray($arr = array())
    {
        $this->logger->debug('responseArray', $arr);
        return $this->response->array($arr);
    }

    /**
     * @param $item
     * @param $transformer
     * @return \Dingo\Api\Http\Response
     */
    protected function responseItem($item, $transformer)
    {
        $this->logger->debug('responseItem', $item);
        return $this->response->item($item, $transformer);
    }

    /**
     * @param Collection $collection
     * @param $transformer
     * @return \Dingo\Api\Http\Response
     */
    protected function responseCollection(Collection $collection, $transformer)
    {
        $this->logger->debug('responseCollection', $collection);
        return $this->response->collection($collection, $transformer);
    }

    /**
     * @param Paginator $paginator
     * @param $transformer
     * @return \Dingo\Api\Http\Response
     */
    protected function responsePaginator(Paginator $paginator, $transformer)
    {
        $this->logger->debug('responsePaginator', $paginator);
        return $this->response->paginator($paginator, $transformer);
    }

}
