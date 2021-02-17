<?php

declare(strict_types = 1);

namespace Jnjxp\ProductionHost;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ProductionHost implements MiddlewareInterface, StatusCodeInterface
{
    protected $responseFactory;

    protected $host;

    protected $status = self::STATUS_TEMPORARY_REDIRECT;

    public function __construct(ResponseFactoryInterface $responseFactory, string $host = null)
    {
        $this->responseFactory = $responseFactory;
        $this->host = $host ? trim($host) : null;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->host) {
            return $this->redirect($request);
        }
        return $handler->handle($request);
    }

    protected function redirect(ServerRequestInterface $request) : ResponseInterface
    {
        $uri = $request->getUri()->withHost($this->host);
        return $this->createResponse()->withHeader('Location', (string) $uri);
    }

    protected function createResponse() : ResponseInterface
    {
        return $this->responseFactory->createResponse($this->status);
    }
}
