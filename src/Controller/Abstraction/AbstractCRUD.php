<?php

namespace App\Controller\Abstraction;

use App\Traits\ClassDefinitionTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractCrud extends AbstractController
{
    public $entityClass;
    public $entityName;
    private $fieldNames;
    
}