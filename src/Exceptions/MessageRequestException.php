<?php

namespace MissaelAnda\Whatsapp\Exceptions;

use Illuminate\Http\Client\Response;

class MessageRequestException extends \Exception
{
    public array $errors;

    public function __construct(Response $response)
    {
        $message = $response->json('errors.0.error_data.details', $response->json('errors.0.message',match ($response->status()) {
            404 => 'Resource not found',
            429 => 'Too many requests',
            default => 'Error',
        }));

        parent::__construct($message, $response->json('errors.0.code'));
        $this->errors = $response->json('errors', []);
    }
}
