<?php
namespace Responder\Adapter;

interface RequestTypeFinderAdapterInterface {
    public function isPostRequest();
    public function isGetRequest();
    public function isAjaxRequest();
}