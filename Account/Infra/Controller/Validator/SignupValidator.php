<?php

namespace Account\Infra\Controller\Validator;

use JsonException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class SignupValidator extends BaseValidator implements Validator
{

    readonly ?string $name;
    readonly ?string $email;
    readonly ?string $cpf;
    readonly ?string $password;
    readonly ?bool $isPassenger;
    readonly ?bool $isDriver;
    readonly ?string $carPlate;

    /**
     * @throws JsonException
     */
    public function execute(Request $request): void
    {
        $payload = $request->getPayload();
        $this->name = $payload->get("name");
        $this->email = $payload->get("email");
        $this->cpf = $payload->get("cpf");
        $this->password = $payload->get("password");
        $this->isPassenger = $payload->get("isPassenger");
        $this->isDriver = $payload->get("isDriver");
        $this->carPlate = $payload->get("carPlate");
        $errors = $this->validate($this);
        if($errors) {
            throw new JsonException(json_encode($errors), Response::HTTP_BAD_REQUEST);
        }
    }


    public static function rules(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint("name", new Assert\NotBlank());
        $metadata->addPropertyConstraint("name", new Assert\Type('string'));
        $metadata->addPropertyConstraint("email", new Assert\NotBlank());
        $metadata->addPropertyConstraint("email", new Assert\Email());
        $metadata->addPropertyConstraint("cpf", new Assert\NotBlank());
        $metadata->addPropertyConstraint("cpf", new Assert\Type('string'));
        $metadata->addPropertyConstraint("password", new Assert\NotBlank());
        $metadata->addPropertyConstraint("isPassenger", new Assert\NotBlank());
        $metadata->addPropertyConstraint("isPassenger", new Assert\Type('bool'));
        $metadata->addPropertyConstraint("isDriver", new Assert\NotBlank());
        $metadata->addPropertyConstraint("isDriver", new Assert\Type('bool'));
    }
}