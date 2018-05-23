<?php

namespace WellRESTed\Test\Doubles;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class HandlerDouble implements RequestHandlerInterface
{
    /** @var bool */
    public $called = false;
    /** @var ServerRequestInterface */
    public $request = null;
    /** @var ResponseInterface */
    public $response = null;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->called = true;
        $this->request = $request;
        return $this->response;
    }
}
