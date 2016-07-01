<?php
namespace Responder;

use Responder\Resolver\RequestTypeResolverInterface;
use Responder\Resolver\RequestTypeResolverAdapter;

class Responder
{
    private $actions = [];
    private $requestTypeResolver = null;

    private function __construct() { }

    /**
     * @param RequestTypeResolverInterface $requestTypeResolver
     * @return Responder
     */
    public static function create(RequestTypeResolverInterface $requestTypeResolver) {
        $responder = new self();
        $responder->setRequestTypeResolver($requestTypeResolver);

        return $responder;
    }

    /**
     * @return null
     */
    protected function getRequestTypeResolver() {
        return $this->requestTypeResolver;
    }

    /**
     * @param RequestTypeResolverInterface $requestTypeResolver
     */
    public function setRequestTypeResolver(RequestTypeResolverInterface $requestTypeResolver) {
        $this->requestTypeResolver = RequestTypeResolverAdapter::create($requestTypeResolver);
    }

    /**
     * Register post callback
     * @param callable $callback
     * @return Responder
     */
    public function whenPost(callable $callback) {
        return $this->when('post', $callback);
    }

    /**
     * Register put callback
     * @param callable $callback
     * @return Responder
     */
    public function whenPut(callable $callback) {
        return $this->when('put', $callback);
    }

    /**
     * Register patch callback
     * @param callable $callback
     * @return Responder
     */
    public function whenPatch(callable $callback) {
        return $this->when('patch', $callback);
    }

    /**
     * Register delete callback
     * @param callable $callback
     * @return Responder
     */
    public function whenDelete(callable $callback) {
        return $this->when('delete', $callback);
    }

    /**
     * Register get callback
     * @param callable $callback
     * @return Responder
     */
    public function whenGet(callable $callback) {
        return $this->when('get', $callback);
    }

    /**
     * Register post+ajax callback
     * @param callable $callback
     * @return Responder
     */
    public function whenPostAjax(callable $callback) {
        return $this->when('post+ajax', $callback);
    }

    /**
     * Register get+ajax callback
     * @param callable $callback
     * @return Responder
     */
    public function whenGetAjax(callable $callback) {
        return $this->when('get+ajax', $callback);
    }

    /**
     * Generic callback registration
     * @param callable $callback
     * @return Responder
     */
    private function when($method, callable $callback) {
        $this->actions[$method] = $callback;

        return $this;
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function respond() {
        if (!$this->getRequestTypeResolver() instanceof RequestTypeResolverAdapter) {
            return false;
        }

        $type = $this->getRequestTypeResolver()->getRequestType();
        if (!isset($this->actions[$type])) {
            return false;
        }

        return call_user_func($this->actions[$type]);
    }
}