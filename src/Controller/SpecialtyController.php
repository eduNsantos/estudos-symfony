<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Traits\CrudGenerator;
use App\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SpecialtyController extends AbstractCrudController
{
    /**
     * @Route("/specialty", name="specialty")
     */
    public function index(Request $request, TranslatorInterface $translator, ValidatorInterface $validator)
    {
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass;

        $form = $this->createForm($this->getFormClass());
        
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entity = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            
            $specialties = explode(',', $entity->getName());
            
            foreach ($specialties as $specialty) {
                $entityObj = new $entityClass;
                $entityObj->setName($specialty);
                $entityManager->persist($entityObj);

                $this->validateForm($validator, $entityObj);
            }   

            $this->checkFormErrors();

            if (isset($errors)) {
                return $this->json(array_merge([
                    'data' => $errors,
                    'entityName' => $this->getEntityName()
                ]), 400);
            } 

            $entityManager->flush();
            
            return $this->json(array_merge([
                'entityName' => $translator->trans($this->getEntityName()),
                'data' => $this->getTableData(true)
            ]), 200);
        }


        return $this->render($this->getEntityName() . '/index.html.twig', [
            'form' => $form->createView(),
            'table' => $this->getTableData(true)
        ]);
    }
}
