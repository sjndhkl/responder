<?php
namespace Responder\RequestTypeFinder;

use Responder\Adapter\RequestTypeFinderAdapterInterface;

class RequestTypeFinder implements RequestTypeFinderInterface {
    private $adapter = null;

    private function __construct() {}

    public static function create(RequestTypeFinderAdapterInterface $adapter) {
        $requestTypeFinder = new RequestTypeFinder();
        $requestTypeFinder->setAdapter($adapter);

        return $requestTypeFinder;
    }

    public function setAdapter(RequestTypeFinderAdapterInterface $adapter) {
        $this->adapter= $adapter;
    }

    public function getRequestType()
    {
        $requestType = '';

        if ($this->adapter->isPostRequest()) {
            $requestType = 'post';
        }
        if ($this->adapter->isGetRequest()) {
            $requestType = 'get';
        }
        if ($this->adapter->isAjaxRequest()) {
            $requestType .= "+ajax";
        }

        return $requestType;
    }
}