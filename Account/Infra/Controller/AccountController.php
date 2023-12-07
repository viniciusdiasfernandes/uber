<?php

namespace Account\Infra\Controller;

use Account\Application\Repository\AccountRepository;
use Account\Application\UseCase\DTO\GetAccountInput;
use Account\Application\UseCase\DTO\SignupInput;
use Account\Application\UseCase\GetAccount;
use Account\Application\UseCase\Signup;
use Account\Infra\Controller\Validator\SignupValidator;
use Account\Infra\Database\Connection;
use Account\Infra\Database\MySqlPromiseAdapter;
use Account\Infra\Queue\RabbitMQAdapter;
use Account\Infra\Repository\AccountRepositoryDatabase;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AccountController
{
    private AccountRepository $accountRepository;
    public function __construct()
    {
        $this->accountRepository = new AccountRepositoryDatabase(new MySqlPromiseAdapter());
    }

    public function signup(Request $request): JsonResponse
    {
        try {
            $validator = new SignupValidator();
            $validator->execute($request);
            $queue = new RabbitMQAdapter();
            $signup = new Signup($this->accountRepository, $queue);
            $requestData = $request->getPayload();
            $input = new SignupInput(
                name: $requestData->get("name"),
                email: $requestData->get("email"),
                cpf: $requestData->get("cpf"),
                password: $requestData->get("password"),
                isPassenger: $requestData->get("isPassenger"),
                isDriver: $requestData->get("isDriver"),
                carPlate: $requestData->get("carPlate")
            );
            $output = $signup->execute($input);
            return new JsonResponse($output);
        } catch (JsonException $jsonException) {
            return new JsonResponse(json_decode($jsonException->getMessage()), $jsonException->getCode());
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function getById(string $accountId)
    {
        $getAccount = new GetAccount($this->accountRepository);
        $input = new GetAccountInput($accountId);
        try {
            $output = $getAccount->execute($input);
            return new JsonResponse($output);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function getByEmail()
    {
        echo "getByEmail";
    }

    public function activate()
    {
        echo "activate";
    }
}