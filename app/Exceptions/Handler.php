<?php

namespace App\Exceptions;

use CodeIgniter\Debug\ExceptionHandlerInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

class Handler implements ExceptionHandlerInterface
{
    protected $config;

    public function __construct($config = null)
    {
        $this->config = $config;
    }

    public function handle(
        Throwable $exception,
        RequestInterface $request,
        ResponseInterface $response,
        int $statusCode,
        int $exitCode
    ): void {
        // Always add CORS headers
        $response->setHeader('Access-Control-Allow-Origin', '*');
        $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
        $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->setHeader('Access-Control-Max-Age', '86400');

        // Prepare the error message
        $message = ENVIRONMENT === 'development'
            ? $exception->getMessage()
            : 'An internal server error occurred.';

        // Send JSON response
        $response
            ->setStatusCode($statusCode)
            ->setContentType('application/json')
            ->setJSON([
                'type'    => get_class($exception),
                'message' => $exception->getMessage(),
                'file'    => $exception->getFile(),
                'line'    => $exception->getLine(),
                'trace'   => explode("\n", $exception->getTraceAsString()),
            ])
            ->send();

        exit($exitCode);
    }
}