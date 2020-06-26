<?php

namespace WellRESTed\Test\TestCases;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use WellRESTed\Message\ServerRequest;
use WellRESTed\Test\Doubles\HandlerDouble;

abstract class MiddlewareTestCase extends TestCase
{
    /** @var ServerRequestInterface */
    protected $request;
    /** @var HandlerDouble */
    protected $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new ServerRequest();
        $this->handler = new HandlerDouble();
    }

    protected function dispatch(): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        return $middleware->process($this->request, $this->handler);
    }

    abstract protected function getMiddleware(): MiddlewareInterface;
}
