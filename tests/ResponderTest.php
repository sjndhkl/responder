<?php

class ResponderTest extends PHPUnit_Framework_TestCase
{

    public function test_responder_responds_ajax_get_request() {
        $request = \Symfony\Component\HttpFoundation\Request::create('/test','GET');
        $request->headers->add(["X-Requested-With"=>"XMLHttpRequest"]);
        $srtf = new SymfonyRequestTypeFinderAdapter($request);

        $message = \Responder\Responder::create($srtf)->whenGet(function(){
            return "I was Get!";
        })->whenGetAjax(function() {
           return "I was Get+Ajax";
        })->respond();

        $this->assertEquals("I was Get+Ajax", $message);
    }

    public function test_responder_responds_ajax_post_request() {
        $request = \Symfony\Component\HttpFoundation\Request::create('/test','POST');
        $request->headers->add(["X-Requested-With"=>"XMLHttpRequest"]);
        $srtf = new SymfonyRequestTypeFinderAdapter($request);
        $responder = \Responder\Responder::create($srtf)->whenGet(function(){
            return "I was Get!";
        })->whenGetAjax(function() {
            return "I was Get+Ajax";
        })->whenPostAjax(function(){
            return "ok post";
        });
        $this->assertEquals("ok post", $responder->respond());

        $request = \Symfony\Component\HttpFoundation\Request::create('/test','GET');
        $request->headers->add(["X-Requested-With"=>"XMLHttpRequest"]);
        $srtf = new SymfonyRequestTypeFinderAdapter($request);
        $responder->setRequestTypeFinder($srtf);

        $this->assertEquals("I was Get+Ajax", $responder->respond());

        $request = \Symfony\Component\HttpFoundation\Request::create('/test','GET');
        $srtf = new SymfonyRequestTypeFinderAdapter($request);
        $responder->setRequestTypeFinder($srtf);

        $this->assertEquals("I was Get!", $responder->respond());

    }


}
