<?php

namespace App\Controller\Abstraction;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class AbstractCRUD extends AbstractController
{
    protected $entityClass;
    private $fieldNames;
    
    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Set the value of entityClass
     *
     * @return  self
     */ 
    abstract protected function setEntityClass($name);

    /**
     * Get the value of fieldNames
     */ 
    public function getFieldNames()
    {
        $em = $this->getDoctrine()->getManager();
        $this->fieldNames = $em->getClassMetadata($this->entityClass)->fieldNames;

        return $this->fieldNames;
    }

    /**
     * Set the value of fieldNames
     *
     * @return  self
     */ 
    public function setFieldNames($fieldNames)
    {
        $this->fieldNames = $fieldNames;

        return $this;
    }
}