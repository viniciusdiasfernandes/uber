<?php

namespace Account\Infra\Controller\Validator;

use JsonException;
use Symfony\Component\Validator\Validation;

abstract class BaseValidator
{
    public static function validate(Validator $class): array
    {
        $validator = Validation::createValidatorBuilder()->addMethodMapping("rules")->getValidator();
        $violations = $validator->validate($class);
        $errorBag = [];
        if(count($violations) > 0) {
            for($i = 0; $i < count($violations); $i++) {
                $violation = $violations->get($i);
                $errorBag[] = [
                    $violation->getPropertyPath() => $violation-> getMessage()
                ];
            }
        }
        return $errorBag;
    }
}