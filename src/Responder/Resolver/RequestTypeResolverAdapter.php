<?php
namespace Responder\Resolver;

class RequestTypeResolverAdapter
{
    private $resolver = null;

    private function __construct() { }

    /**
     * @param RequestTypeResolverInterface $resolver
     * @return RequestTypeResolverAdapter
     */
    public static function create(RequestTypeResolverInterface $resolver) {
        $requestResolver = new self();
        $requestResolver->setResolver($resolver);

        return $requestResolver;
    }

    /**
     * @param RequestTypeResolverInterface $resolver
     */
    public function setResolver(RequestTypeResolverInterface $resolver) {
        $this->resolver = $resolver;
    }

    /**
     * @return string
     */
    public function getRequestType() {
        $requestType = '';

        if ($this->resolver->isPostRequest()) {
            $requestType = 'post';
        }
        if ($this->resolver->isGetRequest()) {
            $requestType = 'get';
        }
        if ($this->resolver->isPutRequest()) {
            $requestType = "put";
        }
        if ($this->resolver->isPatchRequest()) {
            $requestType = "patch";
        }
        if ($this->resolver->isDeleteRequest()) {
            $requestType = "delete";
        }
        if ($this->resolver->isAjaxRequest()) {
            $requestType .= "+ajax";
        }

        return $requestType;
    }
}