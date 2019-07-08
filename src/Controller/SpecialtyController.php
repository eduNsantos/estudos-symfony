<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Traits\CrudGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class SpecialtyController extends AbstractController
{
    use CrudGenerator;

    /**
     * @Route("/specialty", name="specialty")
     */
    public function index(Request $request, ValidatorInterface $validator, TranslatorInterface $translator)
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

                $error = $validator->validate($entityObj);
                if (count($error)) {
                    return $this->json($error);
                    // dd($error[0]->getMessageTemplate(), $error);
                }
            }   

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
