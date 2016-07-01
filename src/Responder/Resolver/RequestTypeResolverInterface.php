<?php
namespace Responder\Resolver;

interface RequestTypeResolverInterface
{
    public function isPostRequest();

    public function isGetRequest();

    public function isAjaxRequest();

    public function isPutRequest();

    public function isPatchRequest();

    public function isDeleteRequest();
}