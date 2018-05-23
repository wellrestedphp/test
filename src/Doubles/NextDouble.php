<?php

namespace WellRESTed\Test\Doubles;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NextDouble
{
    /** @var bool */
    public $called = false;
    /** @var ServerRequestInterface */
    public $request = null;
    /** @var ResponseInterface */
    public $response = null;
    /** @var ResponseInterface */
    public $upstreamResponse = null;

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ) {
        $this->called = true;
        $this->request = $request;
        $this->response = $response;
        if ($this->upstreamResponse) {
            return $this->upstreamResponse;
        } else {
            return $response;
        }
    }
}
