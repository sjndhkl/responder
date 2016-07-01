<?php
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestTypeResolver implements \Responder\Resolver\RequestTypeResolverInterface
{
    private $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function isPostRequest() {
        return $this->request->isMethod('post');
    }

    public function isGetRequest() {
        return $this->request->isMethod('get');
    }

    public function isAjaxRequest()
    {
        return $this->request->isXmlHttpRequest();
    }

    public function isPutRequest() {
        return $this->request->isMethod('put');
    }

    public function isPatchRequest() {
        return $this->request->isMethod('patch');
    }

    public function isDeleteRequest() {
        return $this->request->isMethod('delete');
    }
}