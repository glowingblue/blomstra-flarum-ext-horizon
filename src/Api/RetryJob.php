<?php

namespace Bokt\Horizon\Api;

use Illuminate\Contracts\Queue\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;

class RetryJob implements RequestHandlerInterface
{
    /**
     * @var Factory
     */
    private $queue;

    public function __construct(Factory $queue)
    {
        $this->queue = $queue;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getParsedBody()['id'];

        $this->queue->dispatch(new \Laravel\Horizon\Jobs\RetryFailedJob($id));

        return new EmptyResponse();
    }
}
