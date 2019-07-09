<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait FormTrait
{
    private $errors = [];
    private $message;
    private $fieldName;

    public function getFormClass()
    {
        return 'App\Form\\' . $this->getEntityName() . 'Type'; 
    }

    public function validateForm(ValidatorInterface $validator, $entity)
    {
        $error = $validator->validate($entity);

        if (count($error)) {
            $this->errors[] = $error;
        }
    }

    public function hasFormErrors(): boolean
    {
        return count($this->errors) ? true : false;
    }

    public function checkFormErrors(): array
    {
        $allErrors = [];
        foreach($this->errors as $error) {
            foreach($errors as $data) {
                $allErrors[] =[
                    'fieldName' => $data->getPropertyPath(),
                    'message' => $data->getMessage(),
                    'value' => array_pop($data->getParameters())
                ];
            }
        }

        return $allErrors;
    }
}