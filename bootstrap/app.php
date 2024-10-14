<?php

declare(strict_types=1);

use App\Exceptions\CustomException;
use App\Http\Middleware\JsonMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(JsonMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (ValidationException $e): JsonResponse {

            $errors = [];

            foreach ($e->errors() as $errorMessage) {
                $errors[] = [
                    "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
                    "title"  => "Validation Error",
                    "detail" => $errorMessage,
                ];
            }

            return response()->json(["errors" => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $exceptions->render(function (CustomException $e): JsonResponse {

            $errors = [
                [
                    "status" => $e->getCode(),
                    "title"  => $e->getTitle(),
                    "detail" => $e->getMessage(),
                ],
            ];

            return response()->json(["errors" => $errors], $e->getCode());
        });
    })->create();
