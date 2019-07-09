<?php

namespace App\Controller;

use App\Traits\CrudTrait;
use App\Traits\FormTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractCrudController extends AbstractController
{
    use CrudTrait, FormTrait;
}