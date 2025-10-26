<?php

declare(strict_types=1);


namespace App\Controllers;

use App\Contracts\Services\RegisterServiceInterface;
use App\Contracts\ViewInterface;
use App\Exceptions\ValidationException;
use App\Request;
use App\Responses\RegisterResultResponse;
use App\Views\JsonView;
use App\Views\PhpTemplate;

class RegisterController
{

    public function __construct(
        private readonly RegisterServiceInterface $registerService,
    ) {}

    public function index(): ViewInterface
    {
        return PhpTemplate::load("register");
    }

    public function register(Request $request): ViewInterface
    {
        try
        {
            $user = $this->registerService->registerUser($request->body());

            $response = RegisterResultResponse::successRegister($user->getId());
        }
        catch (ValidationException $validationException)
        {
            $response = RegisterResultResponse::failure(
                $validationException->error,
            );
        }

        return JsonView::make($response->getPayload());
    }
}