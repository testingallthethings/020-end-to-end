<?php

namespace Braddle;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class ApiProblemRenderer implements ErrorRendererInterface
{

    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        return json_encode(
            [
                "status" => 404,
                "title" => "Not Found"
            ]
        );
    }
}