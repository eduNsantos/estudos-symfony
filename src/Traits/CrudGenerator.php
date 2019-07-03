<?php

namespace App\Traits;

use Exception;

trait CrudGenerator
{
    public $entityClass;
    public $entityName;
    public $fieldNames;

    function __construct()
    { 
        $name = substr(__CLASS__, 0, -10);

        $entityName = str_replace('App\Controller\\', '', $name);
        $entityClass = str_replace('Controller', 'Entity', $name);
        
        $this->entityClass = $entityClass;
        $this->entityName = $entityName;
    }

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

    public function getEntityName()
    {
        return $this->entityName;
    }

    public function setEntityName($name)
    {
        $this->entityName = $name;
    }
    
    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    public function getData()
    {
        $em = $this->getDoctrine()->getRepository($this->getEntityClass());
        return $em->findAll();
    }

    public function getFormClass()
    {
        return 'App\Form\\' . $this->getEntityName() . 'Type'; 
    }
}
