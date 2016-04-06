<?php
use Symfony\Component\HttpFoundation\Request;

class SymfonyRequestTypeFinderAdapter implements \Responder\Adapter\RequestTypeFinderAdapterInterface
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

}