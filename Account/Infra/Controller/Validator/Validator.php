<?php

namespace Account\Infra\Controller\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Mapping\ClassMetadata;

interface Validator
{
    public function execute(Request $request): void;
    public static function rules(ClassMetadata $metadata): void;
}