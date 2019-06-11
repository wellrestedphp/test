<?php

namespace WellRESTed\Test\TestCases;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WellRESTed\Message\ServerRequest;

abstract class RequestHandlerTestCase extends TestCase
{
    /** @var ServerRequestInterface */
    protected $request;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new ServerRequest();
    }

    protected function dispatch(): ResponseInterface
    {
        $handler = $this->getHandler();
        return $handler->handle($this->request);
    }

    abstract protected function getHandler(): RequestHandlerInterface;
}
