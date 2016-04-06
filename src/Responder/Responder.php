<?php
namespace Responder;

use Responder\Adapter\RequestTypeFinderAdapterInterface;
use Responder\RequestTypeFinder\RequestTypeFinder;
use Responder\RequestTypeFinder\RequestTypeFinderInterface;

class Responder
{
    private $actions = [];
    private $requestTypeFinder = null;

    private function __construct(){

    }

    /**
     * Create responder instance
     * @param RequestTypeFinderInterface $requestTypeFinder
     * @return Responder
     */
    public static function create(RequestTypeFinderAdapterInterface $requestTypeFinderAdapter) {
        $responder = new Responder();
        $responder->setRequestTypeFinder($requestTypeFinderAdapter);

        return $responder;
    }

    /**
     * @return null
     */
    public function getRequestTypeFinder()
    {
        return $this->requestTypeFinder;
    }

    /**
     * @param null $requestTypeFinder
     */
    public function setRequestTypeFinder(RequestTypeFinderAdapterInterface $requestTypeFinderAdapter)
    {
        $this->requestTypeFinder = RequestTypeFinder::create($requestTypeFinderAdapter);
    }

    /**
     * Register post callback
     * @param callable $callback
     * @return Responder
     */
    public function whenPost(callable $callback)
    {
        return $this->when('post', $callback);
    }

    /**
     * Register get callback
     * @param callable $callback
     * @return Responder
     */
    public function whenGet(callable $callback)
    {
        return $this->when('get', $callback);
    }

    /**
     * Register post+ajax callback
     * @param callable $callback
     * @return Responder
     */
    public function whenPostAjax(callable $callback)
    {
        return $this->when('post+ajax', $callback);
    }

    /**
     * Register get+ajax callback
     * @param callable $callback
     * @return Responder
     */
    public function whenGetAjax(callable $callback)
    {
        return $this->when('get+ajax', $callback);
    }

    /**
     * Generic callback registration
     * @param callable $callback
     * @return Responder
     */
    private function when($method, callable $callback)
    {
        $this->actions[$method] = $callback;

        return $this;
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function respond()
    {
        if(!$this->requestTypeFinder instanceof RequestTypeFinderInterface) {
            return false;
        }

        $type = $this->requestTypeFinder->getRequestType();
        if(!isset($this->actions[$type])) {
            return false;
        }

        return call_user_func($this->actions[$type]);
    }
}