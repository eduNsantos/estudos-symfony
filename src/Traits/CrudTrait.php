<?php

namespace App\Traits;

use Symfony\Component\Translation\TranslatorInterface;

trait CrudTrait
{
    private $entityClass;
    private $entityName;
    private $fieldNames;
    private $translatedEntityName;

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
    
    public function getTranslatedEntityName(TranslatorInterface $translator)
    {
        $this->translatedEntityName = $translator->trans($this->getEntityName);
    }
    
    /**
     * Get the value of entityClass
     */ 
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * getTableData
     *
     * @param  bool $table if true will return de view table
     *
     * @return void
     */
    public function getTableData(bool $table = false)
    {
        $em = $this->getDoctrine()->getRepository($this->getEntityClass());
        if (!$table) {
            return [    
                'fieldNames' => $this->getFieldNames(),
                'items' =>  $em->findAll()
            ];
        }

        return $this->render('crud/table.html.twig', [
            'fieldNames' => $this->getFieldNames(),
            'items' =>  $em->findAll()
        ])->getContent();
    }

}
