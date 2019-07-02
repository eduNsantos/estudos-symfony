<?php

namespace App\Controller;

use App\Entity\Specialty;
use App\Traits\CRUDTrait;
use App\Form\SpecialtyType;
use App\Traits\ClassDefinitionTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SpecialtyController extends AbstractController
{
    use ClassDefinitionTrait;

    /**
     * @Route("/specialty", name="specialty")
     */
    public function index(Request $request)
    {
        $t = $this->getEntityClass();

        $t = new $t;

        $form = $this->createForm('App\Form\\SpecialtyType', $t);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $t = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($t);
            $entityManager->flush();

            $this->addFlash('success', 'Categoria cadastrada com sucesso!');
        }

        return $this->render($this->getEntityName() . '/index.html.twig', [
            'form' => $form->createView(),
            'fieldNames' => $this->getFieldNames(),
            'items' => $this->getData()
        ]);
    }
}
