<?php

namespace WellRESTed\Test\TestCases;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WellRESTed\Message\Response;
use WellRESTed\Message\ServerRequest;
use WellRESTed\Test\Doubles\NextDouble;

abstract class LegacyMiddlewareTestCase extends TestCase
{
    /** @var ServerRequestInterface */
    protected $request;
    /** @var ResponseInterface */
    protected $response;
    /** @var NextDouble */
    protected $next;

    public function setUp(): void
    {
        parent::setUp();
        $this->request = new ServerRequest();
        $this->response = new Response();
        $this->next = new NextDouble();
    }

    protected function dispatch(): ResponseInterface
    {
        $handler = $this->getMiddleware();
        return $handler($this->request, $this->response, $this->next);
    }

    abstract protected function getMiddleware();
}
