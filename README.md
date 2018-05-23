# WellRESTed Test Components

This package provides a handful of test case subclasses for use with [PHPUnit](https://phpunit.de/) and WellRESTed.

To use, add `wellrested/test` to your Composer's `require-dev` section.

## Test Cases

### RequestHandlerTestCase

Subclass [`WellRESTed\Test\TestCases\RequestHandlerTestCase`](src/TestCases/RequestHandlerTestCase.php) to test a handler that implements PSR-15's [`Psr\Http\Server\RequestHandlerInterface`](https://www.php-fig.org/psr/psr-15/#21-psrhttpserverrequesthandlerinterface). Here's an example:

```php
<?php

use Psr\Http\Server\RequestHandlerInterface;
use WellRESTed\Test\TestCases\RequestHandlerTestCase;

class MyHandlerTest extends RequestHandlerTestCase
{
  public function setUp()
  {
    parent::setUp();
    
    // Configure the default request.
    $this->request = $this->request
      ->withAttribute('id', 12345);
  }

  protected function getHandler(): RequestHandlerInterface
  {
    // Return a configured instance of the handler under test.
    return new MyHandler();
  }

  public function testReturns200()
  {
    // Call `dispatch` to send the request to the handler under test and return
    // the response.
    $response = $this->dispatch();
    $this->assertEquals(200, $response->getStatusCode());
  }
}
```

### MiddlewareTestCase

To test middlware implementing PSR-15's [`Psr\Http\Server\MiddlewareInterface`](https://www.php-fig.org/psr/psr-15/#22-psrhttpservermiddlewareinterface), subclass [`WellRESTed\Test\TestCases\MiddlewareTestCase`](src/TestCases/MiddlewareTestCase.php).

```php
<?php

use Psr\Http\Server\RequestHandlerInterface;
use WellRESTed\Message\Response;
use WellRESTed\Test\TestCases\MiddlewareTestCase;

class MyMiddlewareTest extends MiddlewareTestCase
{
  public function setUp()
  {
    parent::setUp();
    
    // Configure the default request.
    $this->request = $this->request
      ->withAttribute('id', 12345);

    // Configure the upstream handler the middleware may call.
    // Set the `response` member to the respone the handler should return.
    $this->handler->response = new Response(200);
  }

  protected function getMiddleware(): MiddlewareInterface
  {
    // Return a configured instance of the middleware under test.
    return new MyMiddleware();
  }

  public function testDelegatesToUpstreamHandler()
  {
    // Call `dispatch` to send the request to the middleware under test and 
    // return the response.
    $response = $this->dispatch();

    // You can make assertions on the `handler` member to check if the upstream
    // handler was called.

    // The `called` member will be true if the handler was called.
    $this->assertTrue($this->handler->called);
    // The `request` member will be set with the request passed to the handler.
    $this->assertSame($this->request, $this->handler->request);
  }
}
```

### LegacyMiddlewareTestCase

To test classes implementing the legacy [`WellRESTed\MiddlewareInterface`](https://github.com/wellrestedphp/wellrested/blob/master/src/MiddlewareInterface.php) or legacy `callable`s, use [`WellRESTed\Test\TestCases\LegacyMiddlewareInterface`](src/TestCases/LegacyMiddlewareTestCase.php).

```php
<?php

class MyLegacyMiddlewareTest extends LegacyMiddlewareTestCase
{
  public function setUp()
  {
    parent::setUp();
    
    // Configure the default request.
    $this->request = $this->request
      ->withAttribute('id', 12345);

    // Configure the `next` member.
    $this->next->upstreamResponse = new Response(200);
  }

  protected function getMiddleware()
  {
    // Return the legacy middleware under test.
    return new MyLegacyMiddleware();
  }

  public function testDelegatesToNext()
  {
    // Call `dispatch` to send the request to the middleware under test and 
    // return the response.
    $response = $this->dispatch();

    // You can make assertions on the `next` member.

    // The `called` member will be true if `next` was called.
    $this->assertTrue($this->next->called);
    // The `request` member will be set with the request passed to `next`.
    $this->assertSame($this->request, $this->next->request);
  }
}
```
